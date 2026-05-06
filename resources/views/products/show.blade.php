@extends('layouts.app')
@section('title', 'Product Details')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">Product Details</h4>
</div>

<div class="card" style="max-width:560px;">
    <div class="card-body p-4">
        <dl class="row mb-0">
            <dt class="col-sm-4 text-muted">Product ID</dt>
            <dd class="col-sm-8">{{ $product->product_id }}</dd>

            <dt class="col-sm-4 text-muted">Product Name</dt>
            <dd class="col-sm-8">{{ $product->product_name }}</dd>

            <dt class="col-sm-4 text-muted">Description</dt>
            <dd class="col-sm-8">{{ $product->description ?: '—' }}</dd>

            <dt class="col-sm-4 text-muted">Category</dt>
            <dd class="col-sm-8">{{ $product->category->category_name ?? '—' }}</dd>

            <dt class="col-sm-4 text-muted">Supplier</dt>
            <dd class="col-sm-8">{{ $product->supplier->supplier_name ?? '—' }}</dd>

            <dt class="col-sm-4 text-muted">Unit Price</dt>
            <dd class="col-sm-8">₱{{ number_format($product->unit_price, 2) }}</dd>

            <dt class="col-sm-4 text-muted">Quantity</dt>
            <dd class="col-sm-8">
                <span class="badge {{ $product->quantity > 0 ? 'bg-primary' : 'bg-danger' }}">
                    {{ $product->quantity }}
                </span>
            </dd>

            <dt class="col-sm-4 text-muted">Status</dt>
            <dd class="col-sm-8">
                @php $badge = $product->status_badge; @endphp
                <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
            </dd>
        </dl>
    </div>
    <div class="card-footer bg-white d-flex gap-2">
        <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-primary btn-sm">Edit</a>
        <form action="{{ route('products.destroy', $product->product_id) }}" method="POST"
              onsubmit="return confirm('Delete this product?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
    </div>
</div>
@endsection
