<?php
// queries.php
require 'config.php';

function getStudentData($student_id, $father_qatar_id) {
    $conn = getDbConnection();
    
    $sql = "SELECT * FROM StudentView WHERE MD5(StudentID) = ? AND MD5(FatherQatarID) = ? AND AcademicSessionID = 7";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $student_id, $father_qatar_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        $data = ["error" => "Credentials Mismatch"];
    }
    
    $stmt->close();
    $conn->close();
    
    return $data;
}

function getSiblingDetails($fatherQatarID) {
 

    $conn = getDbConnection();

    // Prepare the SQL query to retrieve siblings with the latest AcademicSessionID
    $sql = "SELECT *
        FROM StudentView
        WHERE AcademicSessionID = (
            SELECT MAX(AcademicSessionID)
            FROM StudentView
            WHERE FatherQatarID = ?
        )
        AND FatherQatarID = ?
    ";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("ss", $fatherQatarID, $fatherQatarID);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the records
    $siblings = array();
    while ($row = $result->fetch_assoc()) {
        $siblings[] = $row;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return $siblings;
}

function getStudentForLatestSession($StudentID) {
    $conn = getDbConnection();

    // Prepare the SQL query to retrieve student data with the latest AcademicSessionID
    $sql = "SELECT *
        FROM StudentView
        WHERE AcademicSessionID = (
            SELECT MAX(AcademicSessionID)
            FROM StudentView
            WHERE StudentID = ?
        )
        AND StudentID = ?
    ";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("ss", $StudentID, $StudentID);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the records
    $data = [];
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        $data = ["error" => "Credentials Mismatch"];
    }
    
    $stmt->close();
    $conn->close();
    
    return $data;
}

?>

