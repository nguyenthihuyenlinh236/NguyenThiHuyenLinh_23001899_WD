<?php
class Movie{
    protected $id;
    protected $title;
    protected $price;
    protected $totalSeats;
    protected $availableSeats;
    function __construct($id, $title, $price, $totalSeats)
    {
        $this->id = $id;
        $this->price = $price;
        $this->title = $title;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats;
    }
    function getId(){
        return $this->id;
    }
    function bookTicket($quantity){        
        if ($quantity <= 0){
            echo "Vui long chon so luong ve lon hon 0.";
            echo "<br>";
            return;
        }
        elseif ($this->availableSeats < $quantity){
            echo "Khong du cho trong.";
            echo "<br>";
            return;
        }
        $this->availableSeats -= $quantity;
        echo "Dat $quantity ve phim $this->title thanh cong.";
        echo "<br>";
    }
    function cancelTicket($quantity){
        if ($quantity <= 0){
            echo "Vui long chon so luong ve lon hon 0.";
            echo "<br>";
            return;
        }
        if ($this->getSoldSeats() < $quantity){
            echo "So luong ve huy vuot qua so luong ve da dat.";
            echo "<br>";
            return;
        }
        $this->availableSeats += $quantity;
        echo "Huy $quantity ve phim $this->title thanh cong.";
        echo "<br>";
    }
    function getSoldSeats(){
        return $this->totalSeats - $this->availableSeats;
    }
    function getRevenue(){
        return $this->getSoldSeats()*$this->price;
    }
    function displayInfo(){
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
function displayMovie($movie){
    if($movie !== null){
        $movie->displayInfo();
    }else{
        echo "Khong ton tai!" . "<br>";
    }
}
function findMovieById($movies, $id){
    foreach ($movies as $movie){
        if($movie->getId() === $id){
            return $movie;
        }
    }
    return null;
}
function getTotalRevenue($movies){
    $total = 0;
    foreach($movies as $movie){
        $total += $movie->getRevenue();
    }
    return $total;
}
function getBestSellingMovie($movies){
    if (count($movies)>0){
        $best = $movies[0];
        foreach ($movies as $movie){
            if ($movie->getSoldSeats() > $best->getSoldSeats()){
                $best = $movie;
            }
        }
        return $best;
    }
    return null;
}



$movie1 = new Movie(1, "A New Dawn", 100000, 100);
$movie2 =new Movie(2, "Hello World", 120000, 80);
$movie3 = new Movie(3, "Conan Movie 7", 90000, 120);
$movies = [$movie1,$movie2,$movie3];
$movie1->bookTicket(4);
$movie2->bookTicket(4);
$movie1->cancelTicket(1);
$movie3->bookTicket(-1);
echo "Danh sach cac phim dang chieu:" . "<br>";
foreach($movies as $movie){
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

$movie4 = new Movie(4,"Your name", 90000, 100);
array_push($movies, $movie4);
$movie4->bookTicket(20);
$revenue = getTotalRevenue($movies);
echo "Tong doanh thu cac phim: $revenue." . "<br>";
$bestMovie = getBestSellingMovie($movies);
echo "Phim co so ve ban ra nhieu nhat: " . "<br>";
displayMovie($bestMovie);
echo "<br>";
$findID4 = findMovieById($movies,4);
displayMovie($findID4);
$findID5 = findMovieById($movies,5);
displayMovie($findID5);
?>