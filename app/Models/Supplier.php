<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table      = 'suppliers';
    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_name',
        'contact',
        'email',
        'branch_address',
    ];

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'supplier_id', 'supplier_id');
    }

    public function stockIns(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StockIn::class, 'supplier_id', 'supplier_id');
    }
}
