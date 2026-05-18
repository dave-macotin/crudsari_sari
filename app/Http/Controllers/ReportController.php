<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function inventory()
    {
        $inventory = DB::table('inventory_view')->get();
        return view('reports.inventory', compact('inventory'));
    }

    public function salesSummary()
    {
        $sales = DB::table('sales_summary_view')->get();
        return view('reports.sales_summary', compact('sales'));
    }

    public function receipt($sale_id)
    {
        $receipt = DB::table('receipt_view')->where('sale_id', $sale_id)->get();
        
        if ($receipt->isEmpty()) {
            return redirect()->back()->with('error', 'Receipt not found or no items in this sale.');
        }

        return view('reports.receipt', compact('receipt'));
    }
}
