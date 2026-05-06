<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('sale_id');
            $table->string('receipt_number')->unique();
            $table->string('customer_name')->default('Walk-in Customer');
            $table->date('sale_date');
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
