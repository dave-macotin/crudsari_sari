<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sale extends Model
{
    protected $table      = 'sales';
    protected $primaryKey = 'sale_id';

    protected $fillable = [
        'receipt_number',
        'customer_name',
        'sale_date',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'sale_date'    => 'date',
        'total_amount' => 'decimal:2',
    ];

    /** Auto-generate receipt number before creation */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Sale $sale) {
            if (empty($sale->receipt_number)) {
                $sale->receipt_number = 'RCP-' . strtoupper(Str::random(4)) . '-' . now()->format('mdY');
            }
        });
    }

    public function saleItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SaleItem::class, 'sale_id', 'sale_id');
    }

    /** Recalculate total_amount from sale items */
    public function recalculateTotal(): void
    {
        $this->total_amount = $this->saleItems()->sum(\DB::raw('quantity * unit_price'));
        $this->saveQuietly();
    }
}
