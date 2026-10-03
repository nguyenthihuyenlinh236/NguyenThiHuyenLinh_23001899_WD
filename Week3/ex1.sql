CREATE table cart_items
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);
INSERT INTO cart_items (name, price, quantity)
VALUES 
("egg tart", 100000, 2),
("pancake", 50000, 2),
("black forest", 200000, 2),
("cup cake", 100000, 2),
('cheese cake', 500000,10),
('croissant', 200000, 5);

select * from cart_items;

select * 
from cart_items
where price > 100000;

select * 
from cart_items
where quantity > 5;

SELECT *
FROM cart_items
ORDER BY price DESC;

UPDATE cart_items
SET  price = 300000
WHERE  name = 'pancake';

UPDATE cart_items
SET  quantity = 100
WHERE  name = 'cup cake';

DELETE FROM cart_items 
WHERE name = 'egg tart';

select name, quantity, price*quantity as amount 
from cart_items;

select sum(price*quantity)
from cart_items;
