<?php
require('./database.php');

$searchTerm = ""; //Default: Show all books

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['searchQuery'])) {
    $searchTerm = $_POST['searchQuery'] . "%"; // Enables partial matching

    // ✅ Search only unarchived books by adding "AND archived = 'NO'"
    $queryAccounts = "SELECT * FROM books WHERE archived = 'NO' AND (title LIKE ? OR authors LIKE ? OR genre LIKE ?)";
    $stmt = $conn->prepare($queryAccounts);
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $sqlAccounts = $stmt->get_result();
} else {
    // ✅ Default query: Only unarchived books
    $queryAccounts = "SELECT * FROM books WHERE archived = 'NO'";
    $sqlAccounts = $conn->query($queryAccounts);
}

//Display books (filtered results or all books)
if ($sqlAccounts->num_rows > 0) {
    while ($row = $sqlAccounts->fetch_assoc()) {
        echo "
        <div class='book-container' style='background: white; color: black; border: 3px solid #00964f; width: 15%; height: 45%; margin-bottom: 10px; padding: 10px;'>
            <h3 style='text-align: center;'>{$row['title']}</h3>
            <p><strong>Author:</strong> {$row['authors']}</p>
            <p><strong>Year:</strong> {$row['year_of_publication']}</p>
            <p><strong>Genre:</strong> {$row['genre']}</p>
            <p><strong>Book No:</strong> {$row['book_number']}</p>
            <div class='function-book' style='padding: 0.5rem;'>
                <form method='POST' action='archive-book.php' onsubmit='return confirmArchive(event)'>
                    <input type='hidden' name='book_id' value='{$row['book_id']}'>
                    <button type='submit' name='delete' class='btn btn-danger' style='padding: 0.2rem;'>Archive</button>
                </form>
            </div>
        </div>";
    }
} else {
    echo "<p style='margin:auto;'>No books found.</p>"; //Displays fallback message
}

?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Popper.js (required for Bootstrap JS) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


    <!-- Show the modal when the page loads -->
    <script>
        // Wait for the page to load, then show the modal
        window.onload = function() {
            var myModal = new bootstrap.Modal(document.getElementById('myModal'));
            myModal.show();
        }
        document.getElementById("resetBtn").addEventListener("click", function() {
            window.location.href = window.location.pathname; //Reloads the current page
        });
    </script>
    <script>
    function confirmArchive(event) {
        // Show confirmation prompt
        var userConfirmed = confirm("Are you sure you want to archive this book?");
        
        // If user cancels, stop form submission
        if (!userConfirmed) {
            event.preventDefault();
            return false;
        }
        
        return true; // Allows form submission if user clicks "OK"
    }
</script>


<?php

?>
