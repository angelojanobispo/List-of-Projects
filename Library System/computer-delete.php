<?php
require('./database.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$computerId = $_POST['computerId'] ?? '';

if ($computerId) {
    // Prepare and execute the delete query
    $stmt = $conn->prepare("UPDATE computer_assignments SET name = NULL WHERE computer_id = ?");
    $stmt->bind_param("i", $computerId);

    if ($stmt->execute()) {
        echo "Assignment removed successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid input.";
}

$conn->close();
?>
