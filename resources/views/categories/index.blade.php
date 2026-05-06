@extends('layouts.app')
@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-success"></i>Categories</h4>
    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>New Category
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="text-muted">{{ $category->category_id }}</td>
                    <td>{{ $category->category_name }}</td>
                    <td class="text-end">
                        <a href="{{ route('categories.show', $category->category_id) }}" class="btn btn-sm btn-outline-secondary me-1">
                            View
                        </a>
                        <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-sm btn-outline-primary me-1">
                            Edit
                        </a>
                        <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
