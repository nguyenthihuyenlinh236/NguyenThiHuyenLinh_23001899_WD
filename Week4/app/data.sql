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
('Egg Tart', 25000, 20),
('Tiramisu', 65000, 10),
('Chocolate Brownie', 35000, 15),
('Strawberry Cheesecake', 55000, 8),
('Croissant', 30000, 12),
('Red Velvet Cake', 60000, 10),
('Matcha Roll Cake', 45000, 12),
('Blueberry Muffin', 28000, 18),
('Panna Cotta', 35000, 15),
('Macaron Box', 80000, 6);

create table users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password)
VALUES
('huyenlinh', '$2y$10$2XfUxzX3O5gP4X68UlO2/.qhM683FEP6VXZl.u22mA8w.lgWMilHO');