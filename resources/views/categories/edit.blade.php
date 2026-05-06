@extends('layouts.app')
@section('title', 'Edit Category')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mb-0">Edit Category</h4>
</div>

<div class="card" style="max-width:460px;">
    <div class="card-body p-4">
        @include('layouts.errors')
        <form action="{{ route('categories.update', $category->category_id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label for="category_name" class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                <input type="text" name="category_name" id="category_name"
                       class="form-control @error('category_name') is-invalid @enderror"
                       value="{{ old('category_name', $category->category_name) }}">
                @error('category_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Submit</button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle me-1"></i>Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
