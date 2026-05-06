@extends('layouts.app')
@section('title', 'New Stock In')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('stock_in.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">New Stock In</h4>
</div>

<div class="card" style="max-width:580px;">
    <div class="card-body p-4">
        @include('layouts.errors')
        <form action="{{ route('stock_in.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="product_id" class="form-label fw-semibold">Product <span class="text-danger">*</span></label>
                <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror">
                    <option value="">-- Select Product --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->product_id }}" {{ old('product_id') == $product->product_id ? 'selected' : '' }}>
                            {{ $product->product_name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="supplier_id" class="form-label fw-semibold">Supplier <span class="text-danger">*</span></label>
                <select name="supplier_id" id="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                    <option value="">-- Select Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->supplier_id }}" {{ old('supplier_id') == $supplier->supplier_id ? 'selected' : '' }}>
                            {{ $supplier->supplier_name }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="quantity_added" class="form-label fw-semibold">Quantity Added <span class="text-danger">*</span></label>
                    <input type="number" name="quantity_added" id="quantity_added" min="1"
                           class="form-control @error('quantity_added') is-invalid @enderror"
                           value="{{ old('quantity_added') }}">
                    @error('quantity_added')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="stock_in_price" class="form-label fw-semibold">Cost per Batch</label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="number" step="0.01" min="0" name="stock_in_price" id="stock_in_price"
                               class="form-control @error('stock_in_price') is-invalid @enderror"
                               value="{{ old('stock_in_price', '0.00') }}">
                    </div>
                    @error('stock_in_price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="stockin_date" class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                <input type="date" name="stockin_date" id="stockin_date"
                       class="form-control @error('stockin_date') is-invalid @enderror"
                       value="{{ old('stockin_date', date('Y-m-d')) }}">
                @error('stockin_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label for="notes" class="form-label fw-semibold">Notes</label>
                <textarea name="notes" id="notes" rows="2"
                          class="form-control @error('notes') is-invalid @enderror"
                          placeholder="Optional notes">{{ old('notes') }}</textarea>
                @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Submit</button>
                <button type="reset" class="btn btn-outline-secondary"><i class="bi bi-x-circle me-1"></i>Clear</button>
            </div>
        </form>
    </div>
</div>
@endsection
