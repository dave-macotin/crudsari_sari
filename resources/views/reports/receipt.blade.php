@extends('layouts.app')
@section('title', 'Receipt View')

@section('content')
<div class="mb-4 d-flex align-items-center">
    <a href="{{ route('reports.sales_summary') }}" class="btn btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i> Back to Sales
    </a>
    <h4 class="fw-bold mb-0"><i class="bi bi-receipt me-2 text-info"></i>Receipt Detail (DB View)</h4>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header bg-white text-center py-4">
        <h3 class="fw-bold mb-0">Sari-Sari Store</h3>
        <p class="text-muted mb-0">Official Receipt</p>
    </div>
    
    <div class="card-body">
        @php
            $firstItem = $receipt->first();
        @endphp
        
        <div class="row mb-4">
            <div class="col-6">
                <strong>Receipt No:</strong><br>
                {{ $firstItem->receipt_number }}
            </div>
            <div class="col-6 text-end">
                <strong>Date:</strong><br>
                {{ \Carbon\Carbon::parse($firstItem->sale_date)->format('M d, Y h:i A') }}
            </div>
        </div>
        
        <div class="mb-4">
            <strong>Customer:</strong> {{ $firstItem->customer_name ?? 'Walk-in' }}
        </div>

        <table class="table table-sm border-top border-bottom">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Price</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($receipt as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">₱{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-end">₱{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-4">
            <h5 class="fw-bold">GRAND TOTAL:</h5>
            <h5 class="fw-bold text-success">₱{{ number_format($firstItem->grand_total, 2) }}</h5>
        </div>
    </div>
    
    <div class="card-footer bg-light text-center text-muted small py-3">
        Thank you for shopping with us!
    </div>
</div>
@endsection
