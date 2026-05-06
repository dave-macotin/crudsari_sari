@extends('layouts.app')
@section('title', 'Sale Details & Receipt')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center">
        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
        <h4 class="fw-bold mb-0">Sale Details</h4>
    </div>
    <button onclick="window.print()" class="btn btn-secondary btn-sm"><i class="bi bi-printer me-1"></i>Print Receipt</button>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold">Sale Information</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5 text-muted">Sale ID</dt>
                    <dd class="col-sm-7">{{ $sale->sale_id }}</dd>

                    <dt class="col-sm-5 text-muted">Receipt Number</dt>
                    <dd class="col-sm-7">{{ $sale->receipt_number }}</dd>

                    <dt class="col-sm-5 text-muted">Customer Name</dt>
                    <dd class="col-sm-7">{{ $sale->customer_name ?: 'Walk-in Customer' }}</dd>

                    <dt class="col-sm-5 text-muted">Sale Date</dt>
                    <dd class="col-sm-7">{{ $sale->sale_date->format('M d, Y') }}</dd>

                    <dt class="col-sm-5 text-muted">Total Amount</dt>
                    <dd class="col-sm-7 fw-bold text-success">₱{{ number_format($sale->total_amount, 2) }}</dd>

                    @if($sale->notes)
                        <dt class="col-sm-5 text-muted">Notes</dt>
                        <dd class="col-sm-7">{{ $sale->notes }}</dd>
                    @endif
                </dl>
            </div>
            <div class="card-footer bg-white d-flex gap-2">
                <a href="{{ route('sales.edit', $sale->sale_id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('sales.destroy', $sale->sale_id) }}" method="POST"
                      onsubmit="return confirm('Delete this sale?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-7">
        <!-- Receipt format based on standard POS -->
        <div class="card border-0 shadow-sm" style="max-width: 400px; margin: 0 auto; font-family: monospace;">
            <div class="card-body p-4 text-center">
                <h5 class="fw-bold mb-0">SARI-SARI STORE INC.</h5>
                <small class="d-block text-muted">123 Main Street, Davao City</small>
                <small class="d-block text-muted">VAT Registered TIN 000-000-000-000</small>
                <small class="d-block text-muted mb-3">MIN 123456789</small>

                <div class="text-start border-bottom border-dashed pb-2 mb-2" style="border-bottom-style: dashed !important; border-bottom-width: 1px;">
                    <div class="d-flex justify-content-between">
                        <small>SOLD TO: {{ strtoupper($sale->customer_name ?: 'WALK-IN') }}</small>
                        <small>{{ $sale->sale_date->format('m/d/Y') }}</small>
                    </div>
                    <small class="d-block">RCPT: {{ $sale->receipt_number }}</small>
                </div>

                <table class="table table-borderless table-sm text-start mb-2" style="font-size: 0.85rem;">
                    <thead>
                        <tr style="border-bottom: 1px dashed #dee2e6;">
                            <th class="px-0 py-1" style="width: 50%;">ITEM</th>
                            <th class="px-0 py-1 text-center" style="width: 15%;">QTY</th>
                            <th class="px-0 py-1 text-end" style="width: 15%;">PRICE</th>
                            <th class="px-0 py-1 text-end" style="width: 20%;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->saleItems as $item)
                        <tr>
                            <td colspan="4" class="px-0 pt-2 pb-0 lh-sm">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">{{ str_pad($item->product_id, 10, '0', STR_PAD_LEFT) }}</small>
                                {{ strtoupper(Str::limit($item->product->product_name ?? 'UNKNOWN', 25)) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="px-0 py-0"></td>
                            <td class="px-0 py-0 text-center">{{ $item->quantity }}</td>
                            <td class="px-0 py-0 text-end">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-0 py-0 text-end">{{ number_format($item->subtotal, 2) }}T</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="border-top border-dashed pt-2 mt-2" style="border-top-style: dashed !important; border-top-width: 1px;">
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>TOTAL</span>
                        <span>{{ number_format($sale->total_amount, 2) }}</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-3 text-center border-top">
                    <small class="text-muted">THIS SERVES AS AN OFFICIAL RECEIPT</small><br>
                    <small class="text-muted">Thank you, come again!</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .col-md-7, .col-md-7 * { visibility: visible; }
        .col-md-7 { position: absolute; left: 0; top: 0; width: 100%; }
        .card { box-shadow: none !important; border: none !important; }
    }
</style>
@endsection
