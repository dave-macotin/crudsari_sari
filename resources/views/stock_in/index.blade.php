@extends('layouts.app')
@section('title', 'Stock In')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-arrow-down-circle me-2 text-purple" style="color:#9673a6;"></i>Stock In</h4>
    <a href="{{ route('stock_in.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>New Stock In
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Supplier</th>
                    <th>Qty Added</th>
                    <th>Cost</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stockIns as $stockIn)
                <tr>
                    <td class="text-muted">{{ $stockIn->stockin_id }}</td>
                    <td>{{ $stockIn->product->product_name ?? '—' }}</td>
                    <td>{{ $stockIn->supplier->supplier_name ?? '—' }}</td>
                    <td>{{ $stockIn->quantity_added }}</td>
                    <td>₱{{ number_format($stockIn->stock_in_price, 2) }}</td>
                    <td>{{ $stockIn->stockin_date->format('M d, Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('stock_in.show', $stockIn->stockin_id) }}" class="btn btn-sm btn-outline-secondary me-1">View</a>
                        <a href="{{ route('stock_in.edit', $stockIn->stockin_id) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                        <form action="{{ route('stock_in.destroy', $stockIn->stockin_id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this record?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No stock-in records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
