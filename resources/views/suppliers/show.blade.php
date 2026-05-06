@extends('layouts.app')
@section('title', 'Supplier Details')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">Supplier Details</h4>
</div>

<div class="card" style="max-width:560px;">
    <div class="card-body p-4">
        <dl class="row mb-0">
            <dt class="col-sm-4 text-muted">Supplier ID</dt>
            <dd class="col-sm-8">{{ $supplier->supplier_id }}</dd>

            <dt class="col-sm-4 text-muted">Supplier Name</dt>
            <dd class="col-sm-8">{{ $supplier->supplier_name }}</dd>

            <dt class="col-sm-4 text-muted">Contact</dt>
            <dd class="col-sm-8">{{ $supplier->contact }}</dd>

            <dt class="col-sm-4 text-muted">Email</dt>
            <dd class="col-sm-8">
                @if($supplier->email)
                    <a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a>
                @else
                    —
                @endif
            </dd>

            <dt class="col-sm-4 text-muted">Branch Address</dt>
            <dd class="col-sm-8">{{ $supplier->branch_address ?: '—' }}</dd>
        </dl>
    </div>
    <div class="card-footer bg-white d-flex gap-2">
        <a href="{{ route('suppliers.edit', $supplier->supplier_id) }}" class="btn btn-primary btn-sm">Edit</a>
        <form action="{{ route('suppliers.destroy', $supplier->supplier_id) }}" method="POST"
              onsubmit="return confirm('Delete this supplier?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
    </div>
</div>
@endsection
