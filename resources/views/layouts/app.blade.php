<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sari-Sari Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #212529; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 10px 16px; border-radius: 6px; }
        .sidebar a:hover, .sidebar a.active { background-color: #0d6efd; color: #fff; }
        .sidebar .nav-header { color: #6c757d; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; padding: 10px 16px 4px; }
        .main-content { padding: 30px; }
        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
        .table th { background-color: #f1f3f5; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.04em; }
        .badge-pk { background-color: #0d6efd; font-size: 0.7rem; }
        .brand { color: #fff; font-size: 1.1rem; font-weight: 700; padding: 18px 16px 12px; border-bottom: 1px solid #343a40; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="d-flex">
    {{-- Sidebar --}}
    <div class="sidebar" style="width:220px; flex-shrink:0;">
        <div class="brand"><i class="bi bi-shop me-2"></i>Sari-Sari</div>
        <div class="px-2">
            <div class="nav-header">Inventory</div>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags me-2"></i>Categories
            </a>
            <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <i class="bi bi-truck me-2"></i>Suppliers
            </a>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam me-2"></i>Products
            </a>
            <a href="{{ route('stock_in.index') }}" class="{{ request()->routeIs('stock_in.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-down-circle me-2"></i>Stock In
            </a>
            <div class="nav-header mt-2">Sales</div>
            <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">
                <i class="bi bi-receipt me-2"></i>Sales
            </a>
            <a href="{{ route('sale_items.index') }}" class="{{ request()->routeIs('sale_items.*') ? 'active' : '' }}">
                <i class="bi bi-list-ul me-2"></i>Sale Items
            </a>
        </div>
    </div>

    {{-- Main content --}}
    <div class="flex-grow-1 main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
