<?php
require('./database.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'] ?? '';
$computerId = $_POST['computerId'] ?? '';

if ($name && $computerId) {
    $stmt = $conn->prepare("INSERT INTO computer_assignments (computer_id, name) VALUES (?, ?) ON DUPLICATE KEY UPDATE name=?");
    $stmt->bind_param("iss", $computerId, $name, $name);

    if ($stmt->execute()) {
        echo "Student assigned successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid input.";
}

$conn->close();
?>