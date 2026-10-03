CREATE TABLE movies
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL UNIQUE,
    price DECIMAL(10,2) NOT NULL CHECK (price > 0),
    total_seats INT NOT NULL CHECK (total_seats > 0),
    available_seats INT NOT NULL CHECK (
        available_seats >= 0
        AND available_seats <= total_seats
    )
);

INSERT INTO movies (title, price, total_seats, available_seats)
VALUES
('Doraemon', 80000, 80, 40),
('A New Dawn', 100000, 100, 80),
('Hello World', 120000, 80, 60),
('Conan Movie 7', 90000, 120, 100),
('Your Title', 90000, 100, 70),
('Suzume', 45000, 100, 60);

-- Lấy toàn bộ phim
SELECT *
FROM movies;

-- Phim có giá vé > 100000
SELECT *
FROM movies
WHERE price > 100000;

-- Phim còn > 50 ghế
SELECT *
FROM movies
WHERE available_seats > 50;

-- Sắp xếp giá giảm dần
SELECT *
FROM movies
ORDER BY price DESC;

-- Cập nhật số ghế còn lại
UPDATE movies
SET available_seats = 40
WHERE title = 'Hello World';

-- Xóa phim
DELETE FROM movies
WHERE title = 'Doraemon';

-- Số ghế đã bán của từng phim
SELECT
    title,
    total_seats - available_seats AS sold_seats
FROM movies;

-- Doanh thu từng phim
SELECT
    title,
    (total_seats - available_seats) * price AS revenue
FROM movies;

-- Tổng doanh thu
SELECT
    SUM((total_seats - available_seats) * price) AS total_revenue
FROM movies;

-- Phim bán được nhiều vé nhất
SELECT title
FROM movies
WHERE total_seats - available_seats = (
    SELECT MAX(total_seats - available_seats)
    FROM movies
);
