<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    public function index()
    {
        $stockIns = StockIn::with(['product', 'supplier'])->get();
        return view('stock_in.index', compact('stockIns'));
    }

    public function create()
    {
        $products  = Product::all();
        $suppliers = Supplier::all();
        return view('stock_in.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'     => 'required|integer|exists:products,product_id',
            'supplier_id'    => 'required|integer|exists:suppliers,supplier_id',
            'quantity_added' => 'required|integer|min:1',
            'stock_in_price' => 'nullable|numeric|min:0',
            'stockin_date'   => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        StockIn::create($request->only('product_id', 'supplier_id', 'quantity_added', 'stock_in_price', 'stockin_date', 'notes'));

        return redirect()->route('stock_in.index')
            ->with('success', 'Stock-in record created successfully.');
    }

    public function show(StockIn $stock_in)
    {
        $stock_in->load(['product', 'supplier']);
        return view('stock_in.show', compact('stock_in'));
    }

    public function edit(StockIn $stock_in)
    {
        $products  = Product::all();
        $suppliers = Supplier::all();
        return view('stock_in.edit', compact('stock_in', 'products', 'suppliers'));
    }

    public function update(Request $request, StockIn $stock_in)
    {
        $request->validate([
            'product_id'     => 'required|integer|exists:products,product_id',
            'supplier_id'    => 'required|integer|exists:suppliers,supplier_id',
            'quantity_added' => 'required|integer|min:1',
            'stock_in_price' => 'nullable|numeric|min:0',
            'stockin_date'   => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        $stock_in->update($request->only('product_id', 'supplier_id', 'quantity_added', 'stock_in_price', 'stockin_date', 'notes'));

        return redirect()->route('stock_in.index')
            ->with('success', 'Stock-in record updated successfully.');
    }

    public function destroy(StockIn $stock_in)
    {
        $stock_in->delete();
        return redirect()->route('stock_in.index')
            ->with('success', 'Stock-in record deleted successfully.');
    }
}
