<?php
class Movie
{
    protected $id;
    protected $title;
    protected $price;
    protected $totalSeats;
    protected $availableSeats;
    public function __construct($id, $title, $price, $totalSeats)
    {
        $this->id = $id;
        $this->price = $price;
        $this->title = $title;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats;
    }
    public function getId()
    {
        return $this->id;
    }
    public function bookTicket($quantity)
    {
        if ($quantity <= 0) {
            return false;
        } elseif ($this->availableSeats < $quantity) {
            return false;
        }
        $this->availableSeats -= $quantity;
        return true;
    }
    public function cancelTicket($quantity)
    {
        if ($quantity <= 0) {
            return false;
        }
        if ($this->getSoldSeats() < $quantity) {
            return false;
        }
        $this->availableSeats += $quantity;
        return true;
    }
    public function getSoldSeats()
    {
        return $this->totalSeats - $this->availableSeats;
    }
    public function getRevenue()
    {
        return $this->getSoldSeats() * $this->price;
    }
    public function displayInfo()
    {
        echo "Ma phim: " . $this->id . "<br>" .
            "Ten phim: " . $this->title . "<br>" .
            "Gia ve: " . $this->price . "<br>" .
            "Tong so ghe: " . $this->totalSeats . "<br>" .
            "So ghe con lai: " . $this->availableSeats . "<br>" .
            "So ve da ban: " . $this->getSoldSeats() . "<br>" .
            "Doanh thu: " . $this->getRevenue() . "<br>";
        echo "<br>";
    }
}
function createMovie($id, $title, $price, $totalSeats)
{
    if ($id <= 0 || empty($title) || $price <= 0 || $totalSeats <= 0) {
        return null;
    }
    return new Movie($id, $title, $price, $totalSeats);
}
function handleBookTicket($movie, $quantity)
{
    if ($movie !== null && $movie->bookTicket($quantity)) {
        echo "Dat ve thanh cong." . "<br>";
    } else {
        echo "Dat ve that bai." . "<br>";
    }
}
function handleCancelTicket($movie, $quantity)
{
    if ($movie !== null && $movie->cancelTicket($quantity)) {
        echo "Huy ve thanh cong." . "<br>";
    } else {
        echo "Huy ve that bai." . "<br>";
    }
}
function displayMovie($movie)
{
    if ($movie !== null) {
        $movie->displayInfo();
    } else {
        echo "Khong ton tai!" . "<br>";
    }
}
function findMovieById($movies, $id)
{
    foreach ($movies as $movie) {
        if ($movie->getId() === $id) {
            return $movie;
        }
    }
    return null;
}
function getTotalRevenue($movies)
{
    $total = 0;
    foreach ($movies as $movie) {
        $total += $movie->getRevenue();
    }
    return $total;
}
function getBestSellingMovie($movies)
{
    if (count($movies) > 0) {
        $best = $movies[0];
        foreach ($movies as $movie) {
            if ($movie->getSoldSeats() > $best->getSoldSeats()) {
                $best = $movie;
            }
        }
        return $best;
    }
    return null;
}



$movie1 = createMovie(1, "A New Dawn", 100000, 100);
$movie2 = createMovie(2, "Hello World", 120000, 80);
$movie3 = createMovie(3, "Conan Movie 7", 90000, 120);
$movies = [$movie1, $movie2, $movie3];
handleBookTicket($movie1, 4);
handleBookTicket($movie2, 4);
handleCancelTicket($movie1, 1);
handleCancelTicket($movie3, -1);
echo "Danh sach cac phim dang chieu:" . "<br>";
foreach ($movies as $movie) {
    $movie->displayInfo();
}
$revenue = getTotalRevenue($movies);
echo "Tong doanh thu cac phim: $revenue." . "<br>";
$bestMovie = getBestSellingMovie($movies);
echo "Phim co so ve ban ra nhieu nhat: " . "<br>";
displayMovie($bestMovie);
echo "<br>";

$movies1 = [];
$revenue1 = getTotalRevenue($movies1);
echo "Tong doanh thu cac phim: $revenue1." . "<br>";
$best1 = getBestSellingMovie($movies1);
echo "Phim co so ve ban ra nhieu nhat: " . "<br>";
displayMovie($best1);

$movie4 = createMovie(4, "Your name", 90000, 100);
$movies[] = $movie4;
handleBookTicket($movie4, 20);
$revenue = getTotalRevenue($movies);
echo "Tong doanh thu cac phim: $revenue." . "<br>";
$bestMovie = getBestSellingMovie($movies);
echo "Phim co so ve ban ra nhieu nhat: " . "<br>";
displayMovie($bestMovie);
echo "<br>";
$findID4 = findMovieById($movies, 4);
displayMovie($findID4);
$findID5 = findMovieById($movies, 5);
displayMovie($findID5);
$movie5 = createMovie(-1, "", 0, 0);
displayMovie($movie5);
