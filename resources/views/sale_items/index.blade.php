@extends('layouts.app')
@section('title', 'Sale Items')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-list-ul me-2 text-info"></i>Sale Items</h4>
    <a href="{{ route('sale_items.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>New Sale Item
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sale ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($saleItems as $item)
                <tr>
                    <td class="text-muted">{{ $item->sale_item_id }}</td>
                    <td>
                        <a href="{{ route('sales.show', $item->sale_id) }}">
                            {{ $item->sale->receipt_number ?? $item->sale_id }}
                        </a>
                    </td>
                    <td>{{ $item->product->product_name ?? '—' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₱{{ number_format($item->unit_price, 2) }}</td>
                    <td class="fw-semibold">₱{{ number_format($item->subtotal, 2) }}</td>
                    <td class="text-end">
                        <a href="{{ route('sale_items.show', $item->sale_item_id) }}" class="btn btn-sm btn-outline-secondary me-1">View</a>
                        <a href="{{ route('sale_items.edit', $item->sale_item_id) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                        <form action="{{ route('sale_items.destroy', $item->sale_item_id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this sale item?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No sale items found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
