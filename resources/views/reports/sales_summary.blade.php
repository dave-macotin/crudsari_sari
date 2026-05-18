@extends('layouts.app')
@section('title', 'Sales Summary View')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-graph-up me-2 text-success"></i>Sales Summary Report (DB View)</h4>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Sale ID</th>
                    <th>Receipt No.</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Total Items (Types)</th>
                    <th>Total Units Sold</th>
                    <th>Total Amount</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td class="text-muted">{{ $sale->sale_id }}</td>
                    <td><strong>{{ $sale->receipt_number }}</strong></td>
                    <td>{{ $sale->customer_name ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}</td>
                    <td>{{ $sale->total_items }}</td>
                    <td>{{ $sale->total_units_sold }}</td>
                    <td class="text-success fw-bold">₱{{ number_format($sale->total_amount, 2) }}</td>
                    <td class="text-end">
                        <a href="{{ route('reports.receipt', $sale->sale_id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-receipt"></i> View Receipt
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No sales summary data found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
