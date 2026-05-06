@extends('layouts.app')
@section('title', 'New Sale Item')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('sale_items.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">New Sale Item</h4>
</div>

<div class="card" style="max-width:580px;">
    <div class="card-body p-4">
        @include('layouts.errors')
        <form action="{{ route('sale_items.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="sale_id" class="form-label fw-semibold">Sale / Receipt <span class="text-danger">*</span></label>
                <select name="sale_id" id="sale_id" class="form-select @error('sale_id') is-invalid @enderror">
                    <option value="">-- Select Sale --</option>
                    @foreach($sales as $sale)
                        <option value="{{ $sale->sale_id }}" {{ old('sale_id') == $sale->sale_id ? 'selected' : '' }}>
                            {{ $sale->receipt_number }} - {{ $sale->customer_name ?: 'Walk-in' }} ({{ $sale->sale_date->format('M d, Y') }})
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
                        <option value="{{ $product->product_id }}" {{ old('product_id') == $product->product_id ? 'selected' : '' }}>
                            {{ $product->product_name }} (₱{{ number_format($product->unit_price, 2) }} / Stock: {{ $product->quantity }})
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
                           value="{{ old('quantity', 1) }}">
                    @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="unit_price" class="form-label fw-semibold">Unit Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="number" step="0.01" min="0" name="unit_price" id="unit_price"
                               class="form-control @error('unit_price') is-invalid @enderror"
                               value="{{ old('unit_price') }}">
                    </div>
                    @error('unit_price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Add Item</button>
                <button type="reset" class="btn btn-outline-secondary"><i class="bi bi-x-circle me-1"></i>Clear</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Simple script to auto-fill unit_price when product is selected
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');
        const unitPriceInput = document.getElementById('unit_price');
        
        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const text = selectedOption.text;
            
            // Extract price from the option text (e.g., "(₱12.50 / Stock: 5)")
            const match = text.match(/₱([\d,.]+)/);
            if (match && match[1]) {
                const price = parseFloat(match[1].replace(/,/g, ''));
                unitPriceInput.value = price.toFixed(2);
            }
        });
    });
</script>
@endsection
