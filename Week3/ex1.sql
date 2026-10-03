CREATE TABLE cart_items
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO cart_items (name, price, quantity)
VALUES
('Egg Tart', 100000, 2),
('Pancake', 50000, 2),
('Black Forest', 200000, 2),
('Cup Cake', 100000, 2),
('Cheese Cake', 500000, 10),
('Croissant', 200000, 5);

-- Lấy toàn bộ sản phẩm
SELECT *
FROM cart_items;

-- Sản phẩm có giá > 100000
SELECT *
FROM cart_items
WHERE price > 100000;

-- Sản phẩm có số lượng > 5
SELECT *
FROM cart_items
WHERE quantity > 5;

-- Sắp xếp theo giá giảm dần
SELECT *
FROM cart_items
ORDER BY price DESC;

-- Cập nhật giá Pancake
UPDATE cart_items
SET price = 300000
WHERE name = 'Pancake';

-- Cập nhật số lượng Cup Cake
UPDATE cart_items
SET quantity = 100
WHERE name = 'Cup Cake';

-- Xóa Egg Tart
DELETE FROM cart_items
WHERE name = 'Egg Tart';

-- Tính thành tiền của từng sản phẩm
SELECT name, quantity, price * quantity AS amount
FROM cart_items;

-- Tính tổng giá trị giỏ hàng
SELECT SUM(price * quantity) AS total_amount
FROM cart_items;
