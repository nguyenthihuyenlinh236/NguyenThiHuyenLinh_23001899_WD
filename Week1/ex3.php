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

function findBestStudent($students){
    $highest = $students[0];
    foreach ($students as $student){
        if ($student['score'] > $highest['score']){
            $highest = $student;
        }
    }
    return $highest;
}
function findWorstStudent($students){
    $lowest = $students[0];
    foreach ($students as $student){
        if ($student['score'] < $lowest['score']){
            $lowest = $student;
        }
    }
    return $lowest;
}
function countPassedStudents($students){
    $count = 0;
    foreach ($students as $student){
        if ($student['score'] >= 5){
            $count++;
        }
    }
    echo "So sinh vien dat: " . $count . "<br>";
    echo "<br>";
}
function findStudentByName($students, $name){
    $target = [];
    foreach ($students as $student){
        if ($student['name'] == $name){
            $target = $student;
        }
    }
    return $target;
}
function displayStudent($student){
    
    echo "Họ tên: " . $student['name'] . "<br>";
    echo "Tuổi: " . $student['age'] . "<br>";
    echo "Điểm: " . $student['score'] . "<br>";
    echo "<br>";
}

displayStudent(findBestStudent($students));
displayStudent(findWorstStudent($students));
countPassedStudents($students);
displayStudent(findStudentByName($students, "Nguyen Van An"));
?>