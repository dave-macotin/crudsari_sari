<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add categories
        $beverages = Category::create(['category_name' => 'Beverages']);
        $snacks = Category::create(['category_name' => 'Snacks & Sweets']);
        $canned = Category::create(['category_name' => 'Canned Goods']);

        // Add suppliers
        $gaisano = Supplier::create([
            'supplier_name' => 'Gaisano Grand Calinan',
            'contact' => '09123456789',
            'email' => 'sales@gaisano.com',
            'branch_address' => 'Calinan, Davao City'
        ]);

        $sm = Supplier::create([
            'supplier_name' => 'SM Supermarket',
            'contact' => '09987654321',
            'branch_address' => 'Ecoland, Davao City'
        ]);

        // Add products (from receipt)
        $p1 = Product::create([
            'product_name' => 'Nature Spring PRFD 500ml',
            'category_id' => $beverages->category_id,
            'supplier_id' => $gaisano->supplier_id,
            'unit_price' => 8.75,
            'quantity' => 0,
            'status' => 'active'
        ]);

        $p2 = Product::create([
            'product_name' => 'C2 Solo Apple 230ml x 24',
            'category_id' => $beverages->category_id,
            'supplier_id' => $gaisano->supplier_id,
            'unit_price' => 306.30,
            'quantity' => 0,
            'status' => 'active'
        ]);
        
        $p3 = Product::create([
            'product_name' => 'Absolute Distld Wtr 6L',
            'category_id' => $beverages->category_id,
            'supplier_id' => $gaisano->supplier_id,
            'unit_price' => 80.50,
            'quantity' => 0,
            'status' => 'active'
        ]);

        // Trigger stock in to add quantities
        StockIn::create([
            'product_id' => $p1->product_id,
            'supplier_id' => $gaisano->supplier_id,
            'quantity_added' => 100,
            'stock_in_price' => 875.00,
            'stockin_date' => Carbon::now()->subDays(5)
        ]);

        StockIn::create([
            'product_id' => $p2->product_id,
            'supplier_id' => $gaisano->supplier_id,
            'quantity_added' => 10,
            'stock_in_price' => 3063.00,
            'stockin_date' => Carbon::now()->subDays(4)
        ]);

        StockIn::create([
            'product_id' => $p3->product_id,
            'supplier_id' => $gaisano->supplier_id,
            'quantity_added' => 5,
            'stock_in_price' => 400.00,
            'stockin_date' => Carbon::now()->subDays(3)
        ]);

        // Add a sale
        $sale = Sale::create([
            'customer_name' => 'Far East Noble House, Inc.',
            'sale_date' => Carbon::now(),
            'notes' => 'Bulk purchase'
        ]);

        // Add items to sale
        SaleItem::create([
            'sale_id' => $sale->sale_id,
            'product_id' => $p1->product_id,
            'quantity' => 35,
            'unit_price' => 8.75
        ]);

        SaleItem::create([
            'sale_id' => $sale->sale_id,
            'product_id' => $p2->product_id,
            'quantity' => 2,
            'unit_price' => 306.30
        ]);
        
        $sale->recalculateTotal();
    }
}
