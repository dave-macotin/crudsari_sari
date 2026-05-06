@extends('layouts.app')
@section('title', 'New Sale')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">New Sale</h4>
</div>

<div class="card" style="max-width:500px;">
    <div class="card-body p-4">
        @include('layouts.errors')
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="customer_name" class="form-label fw-semibold">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name"
                       class="form-control @error('customer_name') is-invalid @enderror"
                       value="{{ old('customer_name') }}" placeholder="Leave blank for Walk-in Customer">
                @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="sale_date" class="form-label fw-semibold">Sale Date <span class="text-danger">*</span></label>
                <input type="date" name="sale_date" id="sale_date"
                       class="form-control @error('sale_date') is-invalid @enderror"
                       value="{{ old('sale_date', date('Y-m-d')) }}">
                @error('sale_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label for="notes" class="form-label fw-semibold">Notes</label>
                <textarea name="notes" id="notes" rows="2"
                          class="form-control @error('notes') is-invalid @enderror"
                          placeholder="Optional notes about this sale">{{ old('notes') }}</textarea>
                @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Create Sale</button>
                <button type="reset" class="btn btn-outline-secondary"><i class="bi bi-x-circle me-1"></i>Clear</button>
            </div>
        </form>
    </div>
</div>
@endsection
