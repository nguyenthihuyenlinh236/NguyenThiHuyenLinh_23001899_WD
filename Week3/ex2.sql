CREATE table movies
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);

insert into movies (title, price, total_seats,available_seats)
values
("Doraemon", 80000, 80, 40),
("A New Dawn", 100000, 100,80),
("Hello World", 120000, 80, 60),
( "Conan Movie 7", 90000, 120, 100),
("Your title", 90000, 100, 70),
("Suzume", 45000, 100, 60);

select * from movies;

select * 
from movies
where price > 100000;

select * 
from movies
where available_seats > 50;

SELECT *
FROM movies
ORDER BY price DESC;

UPDATE movies
SET  available_seats = 40
WHERE  title = 'Hello World';

DELETE FROM movies 
WHERE title = 'Doraemon';

select title, (total_seats - available_seats) as sold_seats 
from movies;

select title, (total_seats - available_seats)*price as amount
from movies;

select sum((total_seats - available_seats)*price) as total
from movies;

select title
from movies
where (total_seats - available_seats) = (
    select max((total_seats - available_seats)
    from movies)
);
