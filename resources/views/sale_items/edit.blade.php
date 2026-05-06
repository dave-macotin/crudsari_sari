@extends('layouts.app')
@section('title', 'Edit Sale Item')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('sale_items.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">Edit Sale Item</h4>
</div>

<div class="card" style="max-width:580px;">
    <div class="card-body p-4">
        @include('layouts.errors')
        <form action="{{ route('sale_items.update', $sale_item->sale_item_id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="sale_id" class="form-label fw-semibold">Sale / Receipt <span class="text-danger">*</span></label>
                <select name="sale_id" id="sale_id" class="form-select @error('sale_id') is-invalid @enderror">
                    <option value="">-- Select Sale --</option>
                    @foreach($sales as $sale)
                        <option value="{{ $sale->sale_id }}" {{ old('sale_id', $sale_item->sale_id) == $sale->sale_id ? 'selected' : '' }}>
                            {{ $sale->receipt_number }} - {{ $sale->customer_name ?: 'Walk-in' }}
                        </option>
                    @endforeach
                </select>
                @error('sale_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="product_id" class="form-label fw-semibold">Product <span class="text-danger">*</span></label>
                <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror">
                    <option value="">-- Select Product --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->product_id }}" {{ old('product_id', $sale_item->product_id) == $product->product_id ? 'selected' : '' }}>
                            {{ $product->product_name }} (Stock: {{ $product->quantity }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="quantity" class="form-label fw-semibold">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="quantity" min="1"
                           class="form-control @error('quantity') is-invalid @enderror"
                           value="{{ old('quantity', $sale_item->quantity) }}">
                    @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="unit_price" class="form-label fw-semibold">Unit Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="number" step="0.01" min="0" name="unit_price" id="unit_price"
                               class="form-control @error('unit_price') is-invalid @enderror"
                               value="{{ old('unit_price', $sale_item->unit_price) }}">
                    </div>
                    @error('unit_price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update Item</button>
            </div>
        </form>
    </div>
</div>
@endsection
