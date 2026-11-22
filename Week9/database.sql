
CREATE DATABASE IF NOT EXISTS cart
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE cart;

DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    stock INT NOT NULL,
    image VARCHAR(255) NULL,
    CHECK (CHAR_LENGTH(TRIM(name)) > 0),
    CHECK (price > 0),
    CHECK (stock >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO products (name, price, stock) VALUES
('Bút bi', 5000, 20),
('Vở ô ly', 12000, 15),
('Thước kẻ', 8000, 0),
('Bút chì', 4000, 32),
('Tẩy', 3500, 18),
('Hộp bút', 45000, 7),
('Sổ tay', 25000, 12),
('Bìa hồ sơ', 6000, 24),
('Giấy nhớ', 18000, 9),
('Bút dạ quang', 15000, 10),
('Kẹp giấy', 9000, 40),
('Băng dính', 11000, 16),
('Kéo', 22000, 8),
('Hồ dán', 7000, 21),
('Giấy A4', 65000, 6);
