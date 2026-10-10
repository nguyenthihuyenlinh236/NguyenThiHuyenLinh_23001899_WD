CREATE DATABASE shopping_cart
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE shopping_cart;

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO products (name, price, quantity)
VALUES
('Egg Tart', 25000.00, 20),
('Tiramisu', 65000.00, 10),
('Chocolate Brownie', 35000.00, 15),
('Strawberry Cheesecake', 55000.00, 8),
('Croissant', 30000.00, 12),
('Red Velvet Cake', 60000.00, 10),
('Matcha Roll Cake', 45000.00, 12),
('Blueberry Muffin', 28000.00, 18),
('Panna Cotta', 35000.00, 15),
('Macaron Box', 80000.00, 6);
