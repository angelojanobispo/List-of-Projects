<?php
require('./database.php');

if (isset($_POST['submit'])) {
    // Get input values from the form and sanitize them
    $library_number = mysqli_real_escape_string($conn, $_POST['library_number']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);

    // Use prepared statements to prevent SQL injection
    $queryInsert = $conn->prepare("INSERT INTO books (book_number, title, authors, year_of_publication, genre) VALUES (?, ?, ?, ?, ?)");
    $queryInsert->bind_param("sssss", $library_number, $title, $author, $year, $genre);

    // Execute query and check if successful
    if ($queryInsert->execute()) {
        // Display success message and redirect to the book listing page
        echo "<script>
                alert('Book added successfully!');
                window.location.href = 'book.php';  
              </script>";
    } else {
        // Display error message if query fails
        echo "<script>alert('Error adding book: " . $conn->error . "');</script>";
    }

    // Close the prepared statement
    $queryInsert->close();
}
?>
