<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = auth()->user()->gym->products()->latest()->paginate(10);
        return view('gym_admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('gym_admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['gym_id'] = auth()->user()->gym_id;

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('gym.products.index')->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        $this->authorizeProduct($product);
        return view('gym_admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('gym.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);
        $product->delete();
        return redirect()->route('gym.products.index')->with('success', 'Product deleted successfully.');
    }

    private function authorizeProduct(Product $product)
    {
        if ($product->gym_id !== auth()->user()->gym_id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
