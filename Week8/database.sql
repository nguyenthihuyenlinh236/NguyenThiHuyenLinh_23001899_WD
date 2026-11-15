CREATE DATABASE IF NOT EXISTS cart CHARACTER SET utf8mb4;
USE shopping_cart;
SET NAMES utf8mb4;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL CHECK (CHAR_LENGTH(TRIM(name)) > 0),
    price INT NOT NULL CHECK (price > 0),
    stock INT NOT NULL CHECK (stock >= 0)
) DEFAULT CHARACTER SET utf8mb4;

INSERT INTO products (name, price, stock) VALUES
    ('Bút bi', 5000, 20),
    ('Vở ô ly', 12000, 15),
    ('Thước kẻ', 8000, 0);
