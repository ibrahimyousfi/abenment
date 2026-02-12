<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Member;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    private function getGym()
    {
        return auth()->user()->gym;
    }

    public function index(Request $request)
    {
        $query = $this->getGym()->invoices()->with('member')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%$search%")
                  ->orWhereHas('member', function($q) use ($search) {
                      $q->where('full_name', 'like', "%$search%");
                  });
            });
        }

        $invoices = $query->paginate(10);

        return view('gym_admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $members = $this->getGym()->members()->active()->get();
        return view('gym_admin.invoices.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'total_amount' => 'required|numeric|min:0',
            'type' => 'required|string',
        ]);

        $gym = $this->getGym();

        // Generate Invoice Number (INV-GYMID-TIMESTAMP-RAND)
        $invoiceNumber = 'INV-' . $gym->id . '-' . time() . '-' . rand(100, 999);

        $invoice = Invoice::create([
            'gym_id' => $gym->id,
            'member_id' => $request->member_id,
            'invoice_number' => $invoiceNumber,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'total_amount' => $request->total_amount,
            'paid_amount' => 0,
            'status' => 'unpaid',
            'type' => $request->type,
        ]);

        return redirect()->route('gym.invoices.show', $invoice)->with('success', 'Facture créée avec succès.');
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->gym_id !== $this->getGym()->id) {
            abort(403);
        }
        $invoice->load(['member', 'payments']);
        return view('gym_admin.invoices.show', compact('invoice'));
    }

    public function addPayment(Request $request, Invoice $invoice)
    {
        if ($invoice->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . ($invoice->total_amount - $invoice->paid_amount),
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
        ]);

        // Create Payment
        $invoice->payments()->create([
            'gym_id' => $this->getGym()->id,
            'member_id' => $invoice->member_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes,
        ]);

        // Update Invoice Status
        $invoice->paid_amount += $request->amount;
        if ($invoice->paid_amount >= $invoice->total_amount) {
            $invoice->status = 'paid';
        } else {
            $invoice->status = 'partial';
        }
        $invoice->save();

        return back()->with('success', 'Paiement enregistré avec succès.');
    }

    public function downloadPdf(Invoice $invoice)
    {
        if ($invoice->gym_id !== $this->getGym()->id) {
            abort(403);
        }

        // Logic to generate PDF (Assuming DomPDF is installed or will be)
        // If not, we can just return a print view for now
        return view('gym_admin.invoices.print', compact('invoice'));
    }
}
