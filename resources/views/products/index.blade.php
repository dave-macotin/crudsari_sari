@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-box-seam me-2 text-warning"></i>Products</h4>
    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>New Product
    </a>
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
                    <th>Quantity</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="text-muted">{{ $product->product_id }}</td>
                    <td>
                        {{ $product->product_name }}
                        @if($product->description)
                            <div class="small text-muted text-truncate" style="max-width: 150px;">{{ $product->description }}</div>
                        @endif
                    </td>
                    <td>{{ $product->category->category_name ?? '—' }}</td>
                    <td>{{ $product->supplier->supplier_name ?? '—' }}</td>
                    <td>₱{{ number_format($product->unit_price, 2) }}</td>
                    <td>
                        <span class="badge {{ $product->quantity > 0 ? 'bg-primary' : 'bg-danger' }}">
                            {{ $product->quantity }}
                        </span>
                    </td>
                    <td>
                        @php $badge = $product->status_badge; @endphp
                        <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('products.show', $product->product_id) }}" class="btn btn-sm btn-outline-secondary me-1">View</a>
                        <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                        <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
