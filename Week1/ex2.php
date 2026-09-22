<?php
$students = [
    [
        "name" => "Nguyen Van An",
        "age" => 20,
        "score" => 8.5
    ],
    [
        "name" => "Tran Thi Binh",
        "age" => 21,
        "score" => 6.5
    ],
    [
        "name" => "Le Van Cuong",
        "age" => 19,
        "score" => 4.5
    ],
    [
        "name" => "Pham Thi Dung",
        "age" => 20,
        "score" => 7.5
    ]
];

function calculateAverageScore($students){
    $total = 0;
    foreach ($students as $student){
        $total += $student['score'];
    }
    $average = $total / count($students);
    return $average;
}
function getRank($score){
    if ($score >= 8)
        return "Gioi";
    else if ($score >= 6.5)
        return "Kha";
    else if ($score >= 5)
        return "Trung binh";
    else
        return "Yeu";
}
function displayStudent($student){
    
    echo "Họ tên: " . $student['name'] . "<br>";
    echo "Tuổi: " . $student['age'] . "<br>";
    echo "Điểm: " . $student['score'] . "<br>";
    echo "Xep loai: " . getRank($student['score']) . "<br>";
    echo "<br>";

}

foreach ($students as $student){
    displayStudent($student);
}

?>