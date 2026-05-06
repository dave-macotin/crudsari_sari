<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name'  => 'required|string|max:255',
            'contact'        => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'branch_address' => 'nullable|string|max:1000',
        ]);

        Supplier::create($request->only('supplier_name', 'contact', 'email', 'branch_address'));

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully.');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'supplier_name'  => 'required|string|max:255',
            'contact'        => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'branch_address' => 'nullable|string|max:1000',
        ]);

        $supplier->update($request->only('supplier_name', 'contact', 'email', 'branch_address'));

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}
