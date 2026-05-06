<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'category_id'  => 'required|integer|exists:categories,category_id',
            'supplier_id'  => 'required|integer|exists:suppliers,supplier_id',
            'unit_price'   => 'required|numeric|min:0',
        ]);

        Product::create($request->only('product_name', 'description', 'category_id', 'supplier_id', 'unit_price'));

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'supplier']);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'category_id'  => 'required|integer|exists:categories,category_id',
            'supplier_id'  => 'required|integer|exists:suppliers,supplier_id',
            'unit_price'   => 'required|numeric|min:0',
        ]);

        $product->update($request->only('product_name', 'description', 'category_id', 'supplier_id', 'unit_price'));

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
