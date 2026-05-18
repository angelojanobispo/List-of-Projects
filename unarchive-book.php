<?php
require('./database.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    // ✅ Update the archived column back to 'NO'
    $query = "UPDATE books SET archived = 'NO' WHERE book_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        $_SESSION['SuccessMessage'] = "Book successfully moved back to active records!";
    } else {
        $_SESSION['SuccessMessage'] = "Error restoring book!";
    }

    // ✅ Redirect back to book.php
    header("Location: book.php");
    exit();
}

$conn->close();
?>
