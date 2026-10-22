<?php
$name = "Nguyen Thi Huyen Linh";
$score = 10;
function getRank($score)
{
    if ($score >= 8)
        return "Gioi";
    else if ($score >= 6.5)
        return "Kha";
    else if ($score >= 5)
        return "Trung binh";
    else
        return "Yeu";
}
echo "Ten: " . $name . "<br>";
echo "Diem: " . $score . "<br>";
echo "Xep loai: " . getRank($score) . "<br>";
