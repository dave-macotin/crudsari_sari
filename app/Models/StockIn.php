<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $table      = 'stock_in';
    protected $primaryKey = 'stockin_id';

    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantity_added',
        'stock_in_price',
        'stockin_date',
        'notes',
    ];

    protected $casts = [
        'quantity_added' => 'integer',
        'stock_in_price' => 'decimal:2',
        'stockin_date'   => 'date',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
}
