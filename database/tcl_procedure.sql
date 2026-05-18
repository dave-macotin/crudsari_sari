DELIMITER //

DROP PROCEDURE IF EXISTS sp_add_sale_item //

CREATE PROCEDURE sp_add_sale_item(
    IN p_sale_id INT,
    IN p_product_id INT,
    IN p_quantity INT,
    IN p_unit_price DECIMAL(10,2)
)
BEGIN
    -- --------------------------------------------------------
    -- TCL: If any error happens (like your Trigger failing), 
    -- catch the error and execute a ROLLBACK
    -- --------------------------------------------------------
    DECLARE exit handler for sqlexception
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    -- --------------------------------------------------------
    -- TCL: Start the Transaction
    -- --------------------------------------------------------
    START TRANSACTION;

    -- 1. Insert the new sale item (This will automatically fire your Triggers)
    INSERT INTO sale_items (sale_id, product_id, quantity, unit_price, created_at, updated_at)
    VALUES (p_sale_id, p_product_id, p_quantity, p_unit_price, NOW(), NOW());

    -- 2. Recalculate the sale's total amount
    UPDATE sales 
    SET total_amount = (
        SELECT COALESCE(SUM(quantity * unit_price), 0)
        FROM sale_items 
        WHERE sale_id = p_sale_id
    )
    WHERE sale_id = p_sale_id;

    -- --------------------------------------------------------
    -- TCL: If step 1 and 2 succeeded perfectly, save it!
    -- --------------------------------------------------------
    COMMIT;
    
END //

DELIMITER ;
