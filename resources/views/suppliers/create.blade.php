@extends('layouts.app')
@section('title', 'New Supplier')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">New Supplier</h4>
</div>

<div class="card" style="max-width:580px;">
    <div class="card-body p-4">
        @include('layouts.errors')
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="supplier_name" class="form-label fw-semibold">Supplier Name <span class="text-danger">*</span></label>
                <input type="text" name="supplier_name" id="supplier_name"
                       class="form-control @error('supplier_name') is-invalid @enderror"
                       value="{{ old('supplier_name') }}">
                @error('supplier_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="contact" class="form-label fw-semibold">Contact Number <span class="text-danger">*</span></label>
                    <input type="text" name="contact" id="contact"
                           class="form-control @error('contact') is-invalid @enderror"
                           value="{{ old('contact') }}">
                    @error('contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="branch_address" class="form-label fw-semibold">Branch Address</label>
                <textarea name="branch_address" id="branch_address" rows="3"
                          class="form-control @error('branch_address') is-invalid @enderror">{{ old('branch_address') }}</textarea>
                @error('branch_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Submit</button>
                <button type="reset" class="btn btn-outline-secondary"><i class="bi bi-x-circle me-1"></i>Clear</button>
            </div>
        </form>
    </div>
</div>
@endsection
