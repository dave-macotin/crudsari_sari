@extends('layouts.app')
@section('title', 'Category Details')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">Category Details</h4>
</div>

<div class="card" style="max-width:460px;">
    <div class="card-body p-4">
        <dl class="row mb-0">
            <dt class="col-sm-5 text-muted">Category ID</dt>
            <dd class="col-sm-7">{{ $category->category_id }}</dd>

            <dt class="col-sm-5 text-muted">Category Name</dt>
            <dd class="col-sm-7">{{ $category->category_name }}</dd>
        </dl>
    </div>
    <div class="card-footer bg-white d-flex gap-2">
        <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-primary btn-sm">Edit</a>
        <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST"
              onsubmit="return confirm('Delete this category?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
    </div>
</div>
@endsection
