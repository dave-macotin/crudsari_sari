@extends('layouts.app')
@section('title', 'Sale Item Details')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('sale_items.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">Sale Item Details</h4>
</div>

<div class="card" style="max-width:560px;">
    <div class="card-body p-4">
        <dl class="row mb-0">
            <dt class="col-sm-4 text-muted">Item ID</dt>
            <dd class="col-sm-8">{{ $sale_item->sale_item_id }}</dd>

            <dt class="col-sm-4 text-muted">Sale / Receipt</dt>
            <dd class="col-sm-8">
                <a href="{{ route('sales.show', $sale_item->sale_id) }}">
                    {{ $sale_item->sale->receipt_number ?? $sale_item->sale_id }}
                </a>
            </dd>

            <dt class="col-sm-4 text-muted">Product</dt>
            <dd class="col-sm-8">
                <a href="{{ route('products.show', $sale_item->product_id) }}">
                    {{ $sale_item->product->product_name ?? '—' }}
                </a>
            </dd>

            <dt class="col-sm-4 text-muted">Quantity</dt>
            <dd class="col-sm-8">{{ $sale_item->quantity }}</dd>

            <dt class="col-sm-4 text-muted">Unit Price</dt>
            <dd class="col-sm-8">₱{{ number_format($sale_item->unit_price, 2) }}</dd>

            <dt class="col-sm-4 text-muted">Subtotal</dt>
            <dd class="col-sm-8 fw-semibold">₱{{ number_format($sale_item->subtotal, 2) }}</dd>
        </dl>
    </div>
    <div class="card-footer bg-white d-flex gap-2">
        <a href="{{ route('sale_items.edit', $sale_item->sale_item_id) }}" class="btn btn-primary btn-sm">Edit</a>
        <form action="{{ route('sale_items.destroy', $sale_item->sale_item_id) }}" method="POST"
              onsubmit="return confirm('Delete this sale item?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
    </div>
</div>
@endsection
