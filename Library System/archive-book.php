<?php
require('./database.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    // ✅ Archive the book
    $query = "UPDATE books SET archived = 'YES' WHERE book_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        $_SESSION['SuccessMessage'] = "Book archived successfully!";
    } else {
        $_SESSION['SuccessMessage'] = "Error archiving book.";
    }

    // ✅ Redirect back to the book list
    header("Location: book.php");
    exit();
}

$conn->close();
?>
