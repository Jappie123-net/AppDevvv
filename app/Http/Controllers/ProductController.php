<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
 public function index(Request $request)
{
    $query = Product::query();

    // Search
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Filter by category
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // Sorting
    $sortBy = $request->get('sort_by', 'name');
    $order = $request->get('order', 'asc');
    $query->orderBy($sortBy, $order);

    $products = $query->get();
    $categories = Product::select('category')->distinct()->pluck('category');

    return view('products.index', compact('products', 'categories'));
}


    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Product added!');
    }

    public function edit(Product $product) {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) {
        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Product updated!');
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
}
