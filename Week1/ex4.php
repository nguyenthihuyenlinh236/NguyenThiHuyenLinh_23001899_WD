<?php
class Student{
    public $name;
    public $age;
    public $score;
    public function __construct($name, $age, $score)
    {
        $this->name = $name;
        $this->age = $age;
        $this->score = $score;
    }
    public function getRank(){
    if ($this->score >= 8)
        return "Gioi";
    else if ($this->score >= 6.5)
        return "Kha";
    else if ($this->score >= 5)
        return "Trung binh";
    else
        return "Yeu";
    }
    public function isPassed(){
        return $this->score >=5;
    }
    public function display(){
    echo "Họ tên: " . $this->name . "<br>";
    echo "Tuổi: " . $this->age . "<br>";
    echo "Điểm: " . $this->score . "<br>";
    echo "Xep loai: " . $this->getRank() . "<br>";
    echo "<br>";
    }
}
$student1 = new Student("Nguyen Van An", 20, 8.5);
$student2 = new Student("Tran Thi Binh", 21, 6.5);
$student3 = new Student("Le Van Cuong", 19, 4.5);
$student4 = new Student("Pham Thi Dung", 20, 7.5);
$students = [$student1, $student2, $student3, $student4];

function displayStudents($arr){
    foreach ($arr as $student)
        $student->display();
}
function findBestStudent($students){
    $highest = $students[0];
    foreach ($students as $student){
        if ($student->score > $highest->score){
            $highest = $student;
        }
    }
    return $highest;
}
function countPassedStudents($students){
    $count = 0;
    foreach ($students as $student){
        if ($student->score >= 5){
            $count++;
        }
    }
    return $count;
}
function calculateAverageScore($students){
    $total = 0;
    foreach ($students as $student){
        $total += $student->score;
    }
    $average = $total / count($students);
    return $average;
}


displayStudents($students);
echo "Sinh vien cao diem nhat lop:" . "<br>";
findBestStudent($students)->display();
echo "<br>";
echo "So sinh vien dat: " . countPassedStudents($students) . "<br>";
echo "<br>";;
echo "DTB cua ca lop: " . calculateAverageScore($students) . "<br>";
?>