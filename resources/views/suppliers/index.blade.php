@extends('layouts.app')
@section('title', 'Suppliers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-truck me-2 text-primary"></i>Suppliers</h4>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>New Supplier
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supplier Name</th>
                    <th>Contact Info</th>
                    <th>Branch Address</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td class="text-muted">{{ $supplier->supplier_id }}</td>
                    <td class="fw-semibold">{{ $supplier->supplier_name }}</td>
                    <td>
                        <div><i class="bi bi-telephone text-muted me-1"></i>{{ $supplier->contact }}</div>
                        @if($supplier->email)
                            <div><i class="bi bi-envelope text-muted me-1"></i><a href="mailto:{{ $supplier->email }}" class="text-decoration-none">{{ $supplier->email }}</a></div>
                        @endif
                    </td>
                    <td>{{ $supplier->branch_address ? Str::limit($supplier->branch_address, 40) : '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('suppliers.show', $supplier->supplier_id) }}" class="btn btn-sm btn-outline-secondary me-1">View</a>
                        <a href="{{ route('suppliers.edit', $supplier->supplier_id) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                        <form action="{{ route('suppliers.destroy', $supplier->supplier_id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this supplier?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No suppliers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
