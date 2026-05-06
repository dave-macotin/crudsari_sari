<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('categories', 'category_id')->onDelete('restrict');
            $table->foreignId('supplier_id')->constrained('suppliers', 'supplier_id')->onDelete('restrict');
            $table->decimal('unit_price', 10, 2);
            $table->unsignedInteger('quantity')->default(0);
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('out_of_stock');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
