CREATE table cart_items
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);
INSERT INTO cart_items (id, name, price, quantity)
VALUES 
("pen", 10000, 2),
("pencil", 5000, 2),
("book", 20000, 2),
("ruler", 3000, 2),
('eraser', 5000,10);

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
SET  price = 100000
WHERE  name = 'book';

UPDATE cart_items
SET  quantity = 100
WHERE  name = 'pen';

DELETE FROM cart_items 
WHERE name = 'ruler';

select name, quantity, price*quantity as amount 
from cart_items;

select sum(price*quantity)
from cart_items;
