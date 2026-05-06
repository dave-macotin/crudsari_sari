<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        return view('sales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_date'     => 'required|date',
            'customer_name' => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
        ]);

        Sale::create($request->only('sale_date', 'customer_name', 'notes'));

        return redirect()->route('sales.index')
            ->with('success', 'Sale created successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load('saleItems.product');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        return view('sales.edit', compact('sale'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'sale_date'     => 'required|date',
            'customer_name' => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
        ]);

        $sale->update($request->only('sale_date', 'customer_name', 'notes'));

        return redirect()->route('sales.index')
            ->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')
            ->with('success', 'Sale deleted successfully.');
    }
}
