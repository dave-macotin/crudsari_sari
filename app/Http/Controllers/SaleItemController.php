<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleItemController extends Controller
{
    public function index()
    {
        $saleItems = SaleItem::with(['sale', 'product'])->get();
        return view('sale_items.index', compact('saleItems'));
    }

    public function create()
    {
        $sales    = Sale::all();
        $products = Product::all();
        return view('sale_items.create', compact('sales', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_id'    => 'required|integer|exists:sales,sale_id',
            'product_id' => 'required|integer|exists:products,product_id',
            'quantity'   => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $saleItem = SaleItem::create($request->only('sale_id', 'product_id', 'quantity', 'unit_price'));
        $saleItem->sale->recalculateTotal();

        return redirect()->route('sale_items.index')
            ->with('success', 'Sale item created successfully.');
    }

    public function show(SaleItem $sale_item)
    {
        $sale_item->load(['sale', 'product']);
        return view('sale_items.show', compact('sale_item'));
    }

    public function edit(SaleItem $sale_item)
    {
        $sales    = Sale::all();
        $products = Product::all();
        return view('sale_items.edit', compact('sale_item', 'sales', 'products'));
    }

    public function update(Request $request, SaleItem $sale_item)
    {
        $request->validate([
            'sale_id'    => 'required|integer|exists:sales,sale_id',
            'product_id' => 'required|integer|exists:products,product_id',
            'quantity'   => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $sale_item->update($request->only('sale_id', 'product_id', 'quantity', 'unit_price'));
        $sale_item->sale->recalculateTotal();

        return redirect()->route('sale_items.index')
            ->with('success', 'Sale item updated successfully.');
    }

    public function destroy(SaleItem $sale_item)
    {
        $sale = $sale_item->sale;
        $sale_item->delete();
        $sale->recalculateTotal();
        
        return redirect()->route('sale_items.index')
            ->with('success', 'Sale item deleted successfully.');
    }
}
