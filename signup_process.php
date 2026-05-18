<?php
session_start();
require('./database.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        // Handle delete request
        $libraryid = $_POST['libraryid'];

        $delete_sql = "DELETE FROM StudentsInfo WHERE LibraryID=?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $libraryid);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Record deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting record: " . $conn->error;
        }

        // Redirect back to student.php
        header("Location: student.php");
        exit();
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
        if (!empty($_POST['libraryid'])) {
            // Update existing record
            $libraryid = $_POST['libraryid'];
            $update_sql = "UPDATE StudentsInfo SET StudentNumber=?, LastName=?, FirstName=?, MiddleInitial=?, Course=?, Section=?, Address=?, Password=? WHERE LibraryID=?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("isssssssi", $studentnumber, $lastname, $firstname, $middleinitial, $course, $section, $address, $password, $libraryid);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Record updated successfully";
            } else {
                $_SESSION['error'] = "Error updating record: " . $conn->error;
            }
        } else {
            // Check for existing student number before insert
            $check_sql = "SELECT * FROM StudentsInfo WHERE StudentNumber=?";
            $stmt = $conn->prepare($check_sql);
            $stmt->bind_param("s", $studentnumber);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Student number already exists
                $_SESSION['error'] = "Student number already exists!";
            } else {
                // Insert new record
                $insert_sql = "INSERT INTO StudentsInfo (StudentNumber, LastName, FirstName, MiddleInitial, Course, Section, Address, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_sql);
                $stmt->bind_param("isssssss", $studentnumber, $lastname, $firstname, $middleinitial, $course, $section, $address, $password);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "New record created successfully";
                } else {
                    $_SESSION['error'] = "Error creating record: " . $conn->error;
                }
            }
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }

    // Redirect back to fetch_data.php
    header("Location: student.php");
    exit();
}
?>