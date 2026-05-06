@extends('layouts.app')
@section('title', 'Sales')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-receipt me-2 text-danger"></i>Sales</h4>
    <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>New Sale
    </a>
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
                    <th>Total Amount</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td class="text-muted">{{ $sale->sale_id }}</td>
                    <td class="font-monospace">{{ $sale->receipt_number }}</td>
                    <td>{{ $sale->customer_name ?: 'Walk-in Customer' }}</td>
                    <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                    <td class="fw-semibold text-success">₱{{ number_format($sale->total_amount, 2) }}</td>
                    <td class="text-end">
                        <a href="{{ route('sales.show', $sale->sale_id) }}" class="btn btn-sm btn-outline-secondary me-1">View/Receipt</a>
                        <a href="{{ route('sales.edit', $sale->sale_id) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                        <form action="{{ route('sales.destroy', $sale->sale_id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this sale? This will also delete related sale items.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No sales found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
