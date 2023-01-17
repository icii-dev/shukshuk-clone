#remove old data products, stores, transactions

DELETE FROM product_option_values WHERE product_option_id IN (SELECT id FROM product_options WHERE product_id in (SELECT id FROM products WHERE store_id > 17));

DELETE FROM product_options WHERE product_id in (SELECT id FROM products WHERE store_id > 17);

DELETE FROM products WHERE store_id > 17;

DELETE FROM store_payment_method WHERE store_id > 17;

DELETE FROM store_favorite WHERE store_id > 17;

DELETE FROM transactions WHERE store_id > 17;

DELETE FROM store_balances WHERE store_id >17;

DELETE FROM stores WHERE id > 17;

#remove users

DELETE FROM store_favorite WHERE user_id > 5;

DELETE FROM user_address WHERE customer_id > 5;

DELETE FROM users WHERE id >5;