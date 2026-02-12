<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PosController extends Controller
{
    public function index()
    {
        $products = auth()->user()->gym->products()->inStock()->get();
        return view('gym_admin.pos.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card,transfer',
            'client_name' => 'nullable|string|max:255',
            'discount' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $gym = auth()->user()->gym;
            $totalAmount = 0;
            $itemsToCreate = [];

            // Calculate total and verify stock
            foreach ($request->cart as $item) {
                $product = $gym->products()->lockForUpdate()->find($item['id']);

                if (!$product) {
                    throw new \Exception("Produit non trouvé.");
                }

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stock insuffisant pour " . $product->name);
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $itemsToCreate[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];
            }

            // Apply discount
            $discount = $request->input('discount', 0);
            $finalTotal = max(0, $totalAmount - $discount);

            // Create Order
            $order = Order::create([
                'gym_id' => $gym->id,
                'user_id' => auth()->id(),
                'client_name' => $request->client_name,
                'total_amount' => $finalTotal,
                'discount_amount' => $discount,
                'tax_amount' => 0, // Implement tax logic if needed
                'payment_method' => $request->payment_method,
                'status' => 'completed',
            ]);

            // Create Order Items and Update Stock
            foreach ($itemsToCreate as $item) {
                OrderItem::create([
                    'gym_id' => $gym->id,
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);

                $item['product']->decreaseStock($item['quantity']);
            }

            // Create Invoice & Payment for Financial Reporting
            $invoiceNumber = 'INV-' . $gym->id . '-' . time() . '-' . rand(100, 999);
            $invoice = Invoice::create([
                'gym_id' => $gym->id,
                // member_id is null for POS guest checkout, or could be linked if we added member selection to POS
                'invoice_number' => $invoiceNumber,
                'issue_date' => now(),
                'due_date' => now(),
                'total_amount' => $finalTotal,
                'paid_amount' => $finalTotal,
                'status' => 'paid',
                'type' => 'product', // Distinguish from 'subscription'
            ]);

            Payment::create([
                'gym_id' => $gym->id,
                'invoice_id' => $invoice->id,
                // member_id null
                'amount' => $finalTotal,
                'payment_method' => $request->payment_method,
                'payment_date' => now(),
                'notes' => 'Vente POS (Ref: #' . $order->id . ') - Client: ' . ($request->client_name ?? 'Anonyme'),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vente effectuée avec succès!',
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function reports(Request $request)
    {
        $gym = auth()->user()->gym;
        $period = $request->get('period', 'daily'); // daily, monthly
        $date = $request->get('date', now()->toDateString());

        $query = $gym->orders()->with(['items.product', 'cashier']);

        if ($period === 'daily') {
            $query->whereDate('created_at', $date);
        } elseif ($period === 'monthly') {
            $query->whereMonth('created_at', Carbon::parse($date)->month)
                  ->whereYear('created_at', Carbon::parse($date)->year);
        }

        $orders = $query->latest()->get();

        $stats = [
            'total_sales' => $orders->sum('total_amount'),
            'total_orders' => $orders->count(),
            'cash_sales' => $orders->where('payment_method', 'cash')->sum('total_amount'),
            'card_sales' => $orders->where('payment_method', 'card')->sum('total_amount'),
            'transfer_sales' => $orders->where('payment_method', 'transfer')->sum('total_amount'),
        ];

        return view('gym_admin.pos.reports', compact('orders', 'stats', 'period', 'date'));
    }
}
