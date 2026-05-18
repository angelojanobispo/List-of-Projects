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
        $current_hour = date('H:i:s');
        $current_date = date('Y-m-d');

        // Record time out
        $time_sql = "UPDATE TimeRecords SET TimeOut = ?, Date = ? WHERE LibraryID = ? AND TimeOut IS NULL";
        $stmt = $conn->prepare($time_sql);
        $stmt->bind_param("ssi", $current_hour, $current_date, $student_number);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['username'] = $full_name;
        } else {
            $_SESSION['Invalid'] = "You haven't timed in yet";
        }
    } else {
        $_SESSION['Invalid'] = "Account Not Found";
    }
}

header("Location: timeout.php");
exit();
?>