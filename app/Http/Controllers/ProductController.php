<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        $sortBy = $request->get('sort_by', 'name');
        $order = $request->get('order', 'asc');
        $query->orderBy($sortBy, $order);

        $products = $query->get();
        $categories = Category::pluck('name');

        
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product added!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'add_quantity' => 'nullable|integer|min:0',
        ]);

        $newQuantity = $product->quantity;

        if (isset($validated['quantity'])) {
            $newQuantity = $validated['quantity'];
        }

        if (isset($validated['add_quantity'])) {
            $newQuantity += $validated['add_quantity'];
        }

        $product->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'supplier_id' => $validated['supplier_id'],
            'price' => $validated['price'],
            'quantity' => $newQuantity,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated!');
    }

    public function sell(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $sellQty = $request->input('quantity');

        if ($product->quantity < $sellQty) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        $product->quantity -= $sellQty;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product sold successfully!');
    }

    public function addQuantity(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product->quantity += $request->quantity;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Quantity added successfully!');
    }
}
