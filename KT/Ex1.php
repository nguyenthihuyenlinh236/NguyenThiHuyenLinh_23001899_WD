<?php
$name = "Nguyen Thi Huyen Linh";
$score = 10;
$rank = "";

if (!is_numeric($score) || $score > 10 || $score < 0) {
    echo "Diem so khong hop le";
    exit;
}

if ($score >= 8)
    $rank = "Gioi";
else if ($score >= 6.5)
    $rank = "Kha";
else if ($score >= 5)
    $rank = "Trung binh";
else
    $rank = "Yeu";

echo "Ten: " . $name . "<br>";
echo "Diem: " . $score . "<br>";
echo "Xep loai: " . $rank . "<br>";
