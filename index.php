<?php
// index.php
header("Content-Type: application/json");

require 'queries.php';

$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : die(json_encode(["error" => "Student ID required"]));
//$father_qatar_id = isset($_GET['father_qatar_id']) ? $_GET['father_qatar_id'] : die(json_encode(["error" => "Father Qatar ID required"]));

// $data = getStudentData($student_id, $father_qatar_id);

$data = getStudentForLatestSession($student_id);


echo json_encode($data);
?>