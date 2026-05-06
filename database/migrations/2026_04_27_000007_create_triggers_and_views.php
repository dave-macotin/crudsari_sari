<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ── TRIGGER 1: After a sale_item is inserted, decrease product quantity ──
        DB::unprepared('DROP TRIGGER IF EXISTS trg_decrease_stock_on_sale');
        DB::unprepared('
            CREATE TRIGGER trg_decrease_stock_on_sale
            AFTER INSERT ON sale_items
            FOR EACH ROW
            BEGIN
                UPDATE products
                SET
                    quantity = quantity - NEW.quantity,
                    status   = CASE
                                   WHEN (quantity - NEW.quantity) <= 0 THEN \'out_of_stock\'
                                   ELSE status
                               END
                WHERE product_id = NEW.product_id;
            END
        ');

        // ── TRIGGER 2: After a stock_in row is inserted, increase product quantity ──
        DB::unprepared('DROP TRIGGER IF EXISTS trg_increase_stock_on_stockin');
        DB::unprepared('
            CREATE TRIGGER trg_increase_stock_on_stockin
            AFTER INSERT ON stock_in
            FOR EACH ROW
            BEGIN
                UPDATE products
                SET
                    quantity = quantity + NEW.quantity_added,
                    status   = CASE
                                   WHEN status = \'out_of_stock\' AND (quantity + NEW.quantity_added) > 0 THEN \'active\'
                                   ELSE status
                               END
                WHERE product_id = NEW.product_id;
            END
        ');

        // ── TRIGGER 3: After a sale_item is deleted, restore product quantity ──
        DB::unprepared('DROP TRIGGER IF EXISTS trg_restore_stock_on_void');
        DB::unprepared('
            CREATE TRIGGER trg_restore_stock_on_void
            AFTER DELETE ON sale_items
            FOR EACH ROW
            BEGIN
                UPDATE products
                SET 
                    quantity = quantity + OLD.quantity,
                    status = CASE 
                                WHEN status = \'out_of_stock\' AND (quantity + OLD.quantity) > 0 THEN \'active\'
                                ELSE status 
                             END
                WHERE product_id = OLD.product_id;
            END
        ');

        // ── TRIGGER 4: After a stock_in is deleted, deduct product quantity ──
        DB::unprepared('DROP TRIGGER IF EXISTS trg_deduct_stock_on_stockin_delete');
        DB::unprepared('
            CREATE TRIGGER trg_deduct_stock_on_stockin_delete
            AFTER DELETE ON stock_in
            FOR EACH ROW
            BEGIN
                UPDATE products
                SET 
                    quantity = quantity - OLD.quantity_added,
                    status = CASE 
                                WHEN (quantity - OLD.quantity_added) <= 0 THEN \'out_of_stock\'
                                ELSE status 
                             END
                WHERE product_id = OLD.product_id;
            END
        ');

        // ── TRIGGER 5: Before a sale_item is inserted, prevent negative stock ──
        DB::unprepared('DROP TRIGGER IF EXISTS trg_prevent_negative_stock');
        DB::unprepared('
            CREATE TRIGGER trg_prevent_negative_stock
            BEFORE INSERT ON sale_items
            FOR EACH ROW
            BEGIN
                DECLARE current_stock INT;
                SELECT quantity INTO current_stock FROM products WHERE product_id = NEW.product_id;
                
                IF current_stock < NEW.quantity THEN
                    SIGNAL SQLSTATE \'45000\'
                    SET MESSAGE_TEXT = \'Insufficient stock for this product. Transaction aborted.\';
                END IF;
            END
        ');

        // ── VIEW: inventory_view ──────────────────────────────────────────────────
        DB::unprepared('DROP VIEW IF EXISTS inventory_view');
        DB::unprepared('
            CREATE VIEW inventory_view AS
            SELECT
                p.product_id,
                p.product_name,
                c.category_name,
                s.supplier_name,
                p.unit_price,
                p.quantity        AS stock_on_hand,
                p.status
            FROM products p
            LEFT JOIN categories c ON c.category_id = p.category_id
            LEFT JOIN suppliers  s ON s.supplier_id  = p.supplier_id
        ');

        // ── VIEW: sales_summary_view ──────────────────────────────────────────────
        DB::unprepared('DROP VIEW IF EXISTS sales_summary_view');
        DB::unprepared('
            CREATE VIEW sales_summary_view AS
            SELECT
                sa.sale_id,
                sa.receipt_number,
                sa.customer_name,
                sa.sale_date,
                COUNT(si.sale_item_id)          AS total_items,
                SUM(si.quantity)                AS total_units_sold,
                SUM(si.quantity * si.unit_price) AS total_amount
            FROM sales sa
            LEFT JOIN sale_items si ON si.sale_id = sa.sale_id
            GROUP BY
                sa.sale_id,
                sa.receipt_number,
                sa.customer_name,
                sa.sale_date
        ');

        // ── VIEW: receipt_view ────────────────────────────────────────────────────
        DB::unprepared('DROP VIEW IF EXISTS receipt_view');
        DB::unprepared('
            CREATE VIEW receipt_view AS
            SELECT
                sa.sale_id,
                sa.receipt_number,
                sa.customer_name,
                sa.sale_date,
                p.product_name,
                si.quantity,
                si.unit_price,
                (si.quantity * si.unit_price) AS subtotal,
                sa.total_amount               AS grand_total
            FROM sales sa
            JOIN sale_items si ON si.sale_id    = sa.sale_id
            JOIN products   p  ON p.product_id  = si.product_id
            ORDER BY sa.sale_id, si.sale_item_id
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_prevent_negative_stock');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_deduct_stock_on_stockin_delete');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_restore_stock_on_void');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_decrease_stock_on_sale');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_increase_stock_on_stockin');
        DB::unprepared('DROP VIEW IF EXISTS receipt_view');
        DB::unprepared('DROP VIEW IF EXISTS sales_summary_view');
        DB::unprepared('DROP VIEW IF EXISTS inventory_view');
    }
};
