<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'description',
        'category_id',
        'supplier_id',
        'unit_price',
        'quantity',
        'status',
    ];

    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'decimal:2',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    public function saleItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SaleItem::class, 'product_id', 'product_id');
    }

    public function stockIns(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StockIn::class, 'product_id', 'product_id');
    }

    /** Convenience: status badge info */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'active'       => ['label' => 'Active',       'class' => 'bg-success'],
            'inactive'     => ['label' => 'Inactive',     'class' => 'bg-secondary'],
            'out_of_stock' => ['label' => 'Out of Stock', 'class' => 'bg-danger'],
            default        => ['label' => 'Unknown',      'class' => 'bg-dark'],
        };
    }
}
