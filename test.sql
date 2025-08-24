SELECT product_code, product_group_code FROM products
JOIN product_groups ON products.product_group_code = product_groups.code
