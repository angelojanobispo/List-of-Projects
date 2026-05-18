<?php
session_start();
require('./database.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$studentnumber = $_POST['studentnumber'];
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$middleinitial = strtoupper($_POST['middleinitial']);
$course = $_POST['course'];
$section = $_POST['section'];
$address = $_POST['address'];
$password = $_POST['password'];

try {
    // Check if the student number already exists
    $check_sql = "SELECT * FROM StudentsInfo WHERE StudentNumber=?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $studentnumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Student number already exists
        $_SESSION['Error'] = "Student number already exists!";
    } else {
        // Insert new record
        $insert_sql = "INSERT INTO StudentsInfo (StudentNumber, LastName, FirstName, MiddleInitial, Course, Section, Address, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("isssssss", $studentnumber, $lastname, $firstname, $middleinitial, $course, $section, $address, $password);

if ($stmt->execute()) {
    // Retrieve the newly generated Library ID from the database
    $fetchLibraryIdSql = "SELECT LibraryID FROM StudentsInfo WHERE StudentNumber = ?";
    $stmt = $conn->prepare($fetchLibraryIdSql);
    $stmt->bind_param("s", $studentnumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $lastLibraryId = $row['LibraryID']; //Get Library ID properly

    // Store the success message with the correct Library ID
    $_SESSION['SuccessMessage'] = "Thank you for creating an account, $firstname $lastname!<br>Your Library ID: <strong>$lastLibraryId</strong><br>Dont forgot your Library ID and Password<br>Welcome to the library.";
    $_SESSION['ShowWelcomeModal'] = true;
} else {
    $_SESSION['Error'] = "Error creating record: " . $conn->error;
}


    }
} catch (Exception $e) {
    $_SESSION['Error'] = "Error: " . $e->getMessage();
}

// Redirect to timelog.php
header("Location: time_log.php");
exit();
?>
