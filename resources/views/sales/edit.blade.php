@extends('layouts.app')
@section('title', 'Edit Sale')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">Edit Sale</h4>
</div>

<div class="card" style="max-width:500px;">
    <div class="card-body p-4">
        @include('layouts.errors')
        <form action="{{ route('sales.update', $sale->sale_id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="mb-3">
                <label class="form-label fw-semibold text-muted">Receipt Number</label>
                <input type="text" class="form-control" value="{{ $sale->receipt_number }}" disabled>
                <div class="form-text">Receipt number is auto-generated and cannot be changed.</div>
            </div>

            <div class="mb-3">
                <label for="customer_name" class="form-label fw-semibold">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name"
                       class="form-control @error('customer_name') is-invalid @enderror"
                       value="{{ old('customer_name', $sale->customer_name) }}" placeholder="Leave blank for Walk-in Customer">
                @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="sale_date" class="form-label fw-semibold">Sale Date <span class="text-danger">*</span></label>
                <input type="date" name="sale_date" id="sale_date"
                       class="form-control @error('sale_date') is-invalid @enderror"
                       value="{{ old('sale_date', $sale->sale_date->format('Y-m-d')) }}">
                @error('sale_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label for="notes" class="form-label fw-semibold">Notes</label>
                <textarea name="notes" id="notes" rows="2"
                          class="form-control @error('notes') is-invalid @enderror"
                          placeholder="Optional notes about this sale">{{ old('notes', $sale->notes) }}</textarea>
                @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update Sale</button>
            </div>
        </form>
    </div>
</div>
@endsection
