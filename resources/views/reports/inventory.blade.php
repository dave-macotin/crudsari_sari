@extends('layouts.app')
@section('title', 'Inventory View')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>Inventory Report (DB View)</h4>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Unit Price</th>
                    <th>Stock on Hand</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventory as $item)
                <tr>
                    <td class="text-muted">{{ $item->product_id }}</td>
                    <td><strong>{{ $item->product_name }}</strong></td>
                    <td>{{ $item->category_name ?? '—' }}</td>
                    <td>{{ $item->supplier_name ?? '—' }}</td>
                    <td>₱{{ number_format($item->unit_price, 2) }}</td>
                    <td>
                        <span class="badge {{ $item->stock_on_hand > 0 ? 'bg-primary' : 'bg-danger' }}">
                            {{ $item->stock_on_hand }}
                        </span>
                    </td>
                    <td>
                        @if($item->status == 'active')
                            <span class="badge bg-success">Active</span>
                        @elseif($item->status == 'out_of_stock')
                            <span class="badge bg-danger">Out of Stock</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No inventory data found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
