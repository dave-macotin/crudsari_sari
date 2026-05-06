@extends('layouts.app')
@section('title', 'Edit Product')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">Edit Product</h4>
</div>

<div class="card" style="max-width:580px;">
    <div class="card-body p-4">
        @include('layouts.errors')
        <form action="{{ route('products.update', $product->product_id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="product_name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="product_name" id="product_name"
                       class="form-control @error('product_name') is-invalid @enderror"
                       value="{{ old('product_name', $product->product_name) }}" placeholder="Enter product name">
                @error('product_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Optional product description">{{ old('description', $product->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="supplier_id" class="form-label fw-semibold">Supplier <span class="text-danger">*</span></label>
                <select name="supplier_id" id="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                    <option value="">-- Select Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->supplier_id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->supplier_id ? 'selected' : '' }}>
                            {{ $supplier->supplier_name }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="unit_price" class="form-label fw-semibold">Unit Price <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="number" step="0.01" min="0" name="unit_price" id="unit_price"
                           class="form-control @error('unit_price') is-invalid @enderror"
                           value="{{ old('unit_price', $product->unit_price) }}" placeholder="0.00">
                    @error('unit_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
