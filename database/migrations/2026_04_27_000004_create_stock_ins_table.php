<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_in', function (Blueprint $table) {
            $table->id('stockin_id');
            $table->foreignId('product_id')->constrained('products', 'product_id')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers', 'supplier_id')->onDelete('restrict');
            $table->unsignedInteger('quantity_added');
            $table->decimal('stock_in_price', 10, 2)->default(0.00);
            $table->date('stockin_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_in');
    }
};
