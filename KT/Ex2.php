<?php
$prices = [5000, 10000, 15000, 20000, 25000];
function calculateTotal($prices)
{
    if (empty($prices)) {
        return 0;
    }
    $total = 0;
    foreach ($prices as $price) {
        $total += $price;
    }
    return $total;
}

function findMaxPrice($prices)
{
    if (empty($prices)) {
        echo "Khong co gia tri.";
    } else {
        return max($prices);
    }
}

echo "Tong gia tien: " . calculateTotal($prices) . "<br>";
echo "Gia tien lon nhat: " . findMaxPrice($prices);
