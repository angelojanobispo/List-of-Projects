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

        // Check last time record
        $check_sql = "SELECT * FROM TimeRecords WHERE LibraryID = ? ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("i", $student_number);
        $stmt->execute();
        $check_result = $stmt->get_result();

        $current_hour = date('H:i:s');
        $current_date = date('Y-m-d');

        if ($check_result->num_rows > 0) {
            $check_row = $check_result->fetch_assoc();
            if (is_null($check_row['TimeOut'])) {
                // User hasn't timed out, update the record
                $update_sql = "UPDATE TimeRecords SET TimeOut = ?, Date = ? WHERE LibraryID = ? AND TimeOut IS NULL";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("ssi", $current_hour, $current_date, $student_number);
                $stmt->execute();

                $_SESSION['username'] = $full_name;
                $_SESSION['MessageType'] = "timeout";  
                $_SESSION['Message'] = "Goodbye, " . $full_name . "!";
            } else {
                // User has timed out, create a new time-in record
                $time_sql = "INSERT INTO TimeRecords (LibraryID, FullName, TimeIn) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($time_sql);
                $stmt->bind_param("iss", $student_number, $full_name, $current_hour);
                $stmt->execute();

                $_SESSION['username'] = $full_name;
                $_SESSION['MessageType'] = "timein";  
                $_SESSION['Message'] = "Welcome, " . $full_name . "!";
            }
        } else {
            // No previous record, create a new time-in record
            $time_sql = "INSERT INTO TimeRecords (LibraryID, FullName, TimeIn) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($time_sql);
            $stmt->bind_param("iss", $student_number, $full_name, $current_hour);
            $stmt->execute();

            $_SESSION['username'] = $full_name;
            $_SESSION['MessageType'] = "timein";  
            $_SESSION['Message'] = "Welcome, " . $full_name . "!";
        }
    } else {
        $_SESSION['Invalid'] = "Invalid Username or Password!";
    }

    // Ensure session is properly stored before redirection
    header("Location: time_log.php");
    exit();
}
?>
