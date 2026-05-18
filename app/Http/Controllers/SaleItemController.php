<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // OPTION 2: Calling the Stored Procedure (which handles TCL internally)//
        try {
            DB::statement('CALL sp_add_sale_item(?, ?, ?, ?)', [
                $request->sale_id,
                $request->product_id,
                $request->quantity,
                $request->unit_price
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Transaction Failed: ' . $e->getMessage());
        }

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

        DB::transaction(function () use ($request, $sale_item) {
            $sale_item->update($request->only('sale_id', 'product_id', 'quantity', 'unit_price'));
            $sale_item->sale->recalculateTotal();
        });

        return redirect()->route('sale_items.index')
            ->with('success', 'Sale item updated successfully.');
    }

    public function destroy(SaleItem $sale_item)
    {
        DB::transaction(function () use ($sale_item) {
            $sale = $sale_item->sale;
            $sale_item->delete();
            $sale->recalculateTotal();
        });
        
        return redirect()->route('sale_items.index')
            ->with('success', 'Sale item deleted successfully.');
    }
}
