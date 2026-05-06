<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $table      = 'sale_items';
    protected $primaryKey = 'sale_item_id';

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'decimal:2',
    ];

    /** Computed subtotal accessor */
    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->unit_price;
    }

    public function sale(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'sale_id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
