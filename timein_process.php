<?php
session_start();

require('./database.php');

date_default_timezone_set('Asia/Manila'); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $username = $_POST['libraryid'];
    $password = $_POST['password'];

    // Authenticate user
    $sql = "SELECT * FROM StudentsInfo WHERE LibraryID = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_number = $row['LibraryID'];
        $last_name = $row['LastName'];
        $first_name = $row['FirstName'];
        $full_name = $last_name . " " . $first_name;

        // Check if the latest record for the user has both time in and time out
        $check_sql = "SELECT * FROM TimeRecords WHERE LibraryID = ? ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("i", $student_number);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows > 0) {
            $check_row = $check_result->fetch_assoc();
            if (is_null($check_row['TimeIn']) || is_null($check_row['TimeOut'])) {
                // Latest record doesn't have both time in and time out
                $_SESSION['Invalid'] = "You didn't time out yet";
            } else {
                // Latest record has both time in and time out, create a new record for time in
                $current_hour = date('H:i:s');
                $time_sql = "INSERT INTO TimeRecords (LibraryID, FullName, TimeIn) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($time_sql);
                $stmt->bind_param("iss", $student_number, $full_name, $current_hour);
                $stmt->execute();
                $_SESSION['username'] = $full_name;
            }
        } else {
            // No records exist, create a new record for time in
            $current_hour = date('H:i:s');
            $time_sql = "INSERT INTO TimeRecords (LibraryID, FullName, TimeIn) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($time_sql);
            $stmt->bind_param("iss", $student_number, $full_name, $current_hour);
            $stmt->execute();
            $_SESSION['username'] = $full_name;
        }
    } else {
        $_SESSION['Invalid'] = "Account Not Found ";
    }
}

header("Location: timein.php");
exit();
?>