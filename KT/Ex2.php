<?php
$prices = [5000, 10000, 15000, 20000, 25000];
function calculateTotal($prices)
{
    if ($prices === null) {
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
    if ($prices === null) {
        echo "Khong co gia tri.";
    }
    return max($prices);
}

echo calculateTotal($prices);
echo findMaxPrice($prices);
