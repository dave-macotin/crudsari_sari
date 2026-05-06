@extends('layouts.app')
@section('title', 'Stock In Details')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('stock_in.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">Stock In Details</h4>
</div>

<div class="card" style="max-width:560px;">
    <div class="card-body p-4">
        <dl class="row mb-0">
            <dt class="col-sm-5 text-muted">ID</dt>
            <dd class="col-sm-7">{{ $stock_in->stockin_id }}</dd>

            <dt class="col-sm-5 text-muted">Product</dt>
            <dd class="col-sm-7">{{ $stock_in->product->product_name ?? '—' }}</dd>

            <dt class="col-sm-5 text-muted">Supplier</dt>
            <dd class="col-sm-7">{{ $stock_in->supplier->supplier_name ?? '—' }}</dd>

            <dt class="col-sm-5 text-muted">Quantity Added</dt>
            <dd class="col-sm-7 fw-bold">{{ $stock_in->quantity_added }}</dd>

            <dt class="col-sm-5 text-muted">Cost per Batch</dt>
            <dd class="col-sm-7">₱{{ number_format($stock_in->stock_in_price, 2) }}</dd>

            <dt class="col-sm-5 text-muted">Date</dt>
            <dd class="col-sm-7">{{ $stock_in->stockin_date->format('M d, Y') }}</dd>

            <dt class="col-sm-5 text-muted">Notes</dt>
            <dd class="col-sm-7">{{ $stock_in->notes ?: '—' }}</dd>
        </dl>
    </div>
    <div class="card-footer bg-white d-flex gap-2">
        <a href="{{ route('stock_in.edit', $stock_in->stockin_id) }}" class="btn btn-primary btn-sm">Edit</a>
        <form action="{{ route('stock_in.destroy', $stock_in->stockin_id) }}" method="POST"
              onsubmit="return confirm('Delete this record?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
    </div>
</div>
@endsection
