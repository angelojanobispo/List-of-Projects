<?php
    require('./database.php');
?>
<style>
    .reset-btn {
        background-color: #f44336;
        color: white;
    }
    .reset-btn:hover{
        background-color: #d32f2f;
    }
    .search{
        background-color: #4CAF50;
    }
    .search:hover{
        background-color: #45a049;
    }
    
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <!-- Boxicons -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js" defer></script>
    <title>Book Record</title>
    
    <!-- Bootstrap (Optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>

    <div class="panel">
        <div class="side-bar">
            <div class="logo">
                <div class="logo-icon">
                    <img src="image/logo.png" alt="" class="icon">
                </div>
                <div class="logo-text">
                    <h2 class="library">LIBRARY</h2>
                    <h2 class="imus-campus">IMUS-CAMPUS</h2>
                </div>
            </div>
            <hr class="side-hr">
            <ul class="navbar">
                <h2 class="main-menu">MAIN MENU</h2>
                <li>
                    <div class="nav-item">
                        <box-icon name="home" type="solid" color="white"></box-icon>
                        <a href="dashboard.php" id="dashboard" class="nav-link">Dashboard</a>
                    </div>
                </li>
                <li>
                    <div class="nav-item">
                        <box-icon name="graduation" type="solid" color="white"></box-icon>
                        <a href="student.php" id="students" class="nav-link">Students</a>
                    </div>
                </li>
                <li>
                    <div class="nav-item active">
                        <box-icon name="book-add" type="solid" color="white"></box-icon>
                        <a href="book.php" id="books" class="nav-link">Books</a>
                    </div>
                </li>
                <li>
                    <div class="nav-item">
                        <box-icon name='library' color="white"></box-icon>
                        <a href="in-library.php" id="in-library" class="nav-link">In-Library</a>
                    </div>
                </li>
                <li>
                    <div class="nav-item">
                        <box-icon name='desktop' color="white"></box-icon>
                        <a href="computer.php" id="computers" class="nav-link">Computers</a>
                    </div>
                </li>
                <li>
                    <div class="nav-item" style="margin-top: 3rem;">
                        <box-icon name='power-off' color="white"></box-icon>
                        <a href="admin.php" id="computers" class="nav-link">Logout</a>
                    </div>
                </li>
            </ul>
        </div>

        <div class="main-bar">
        <div class="header">
            <h1 class="header-welcome">Welcome Back, Admin</h1>
                <div class="header-right">
                    <a href="#">
                        <box-icon type="solid" name="user-circle" class="header-icon"></box-icon>
                    </a>
                    <h1 class="header-admin">Admin</h1>
                </div>
        </div>
    
        <div class="books" id="div-books">
            <div class="books-header">
                <div class="books-left">
                    <h2 class="title-books">Books Record</h2>
                </div>
                    <?php
                        session_start();
                        if (!empty($_SESSION['SuccessMessage'])) {
                            echo "<div id='successMessage' class='alert alert-success' style='margin-left: 15px; font-size: 16px; color: green;'>" . $_SESSION['SuccessMessage'] . "</div>";
                            unset($_SESSION['SuccessMessage']);
                        }
                    ?>
                <div class="books-right">
                    <a href="dashboard.php" id="home-link">Home</a>
                    <h1 class="books-nav">/ Books Record</h1>
                </div>
            </div>
            <hr class="header-line">
            <form method="POST" action="" class="search-form">
                <div class="form-group">
                    <input type="text" name="searchQuery" placeholder="Search Book" required>
                    <button type="submit" class="search">Search</button>
                    <button type="button" id="resetBtn" class="reset-btn">Reset</button>
                    <button type="button" class="btn btn-danger" style="position: absolute;margin-left:18.5%;margin-top:.5%" id="addArchiveBookBtn" data-bs-toggle="modal" data-bs-target="#archiveBookModal" style="margin-right:5px">ADD ARCHIVE</button>
                    <button type="button" class="btn btn-success" style="position: absolute;margin-left:30%;margin-top:.5%" id="addBookBtn">ADD BOOK</button>
                </div>
            </form>

            <div class="books-body">
                <div class="book-grid">
                    <?php include('./read-book.php'); ?>
                </div>
                    
                <!-- Modal for Adding Book -->
                <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addBookLabel">Add a New Book</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <form action="add-book.php" method="POST">
                    <!-- Form Fields for Adding Book -->
                    <div class="mb-3">
                        <label for="library_number" class="form-label">Book No:</label>
                        <input type="text" class="form-control" id="library_number" name="library_number" placeholder="Enter book number" required>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title of Book:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter book title" required>
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author:</label>
                        <input type="text" class="form-control" id="author" name="author" placeholder="Enter author name" required>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year of Publication:</label>
                        <input type="number" class="form-control" id="year" name="year" placeholder="Enter year of publication" required>
                    </div>
                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre:</label>
                        <input type="text" class="form-control" id="genre" name="genre" placeholder="Enter genre" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit">Add Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Archived Books -->
<div class="modal fade" id="archiveBookModal" tabindex="-1" aria-labelledby="archiveBookLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="archiveBookLabel">Archived Books</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="book-grid" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px;">
                    <?php
                    require('./database.php');
                    $queryArchived = "SELECT * FROM books WHERE archived = 'YES'";
                    $resultArchived = $conn->query($queryArchived);

                    if ($resultArchived->num_rows > 0) {
                        while ($row = $resultArchived->fetch_assoc()) {
                            echo "
                            <div class='book-container' style='background: white; color: black; border: 3px solid #00964f; padding: 10px;'>
                                <h3 style='text-align: center;'>{$row['title']}</h3>
                                <p><strong>Author:</strong> {$row['authors']}</p>
                                <p><strong>Year:</strong> {$row['year_of_publication']}</p>
                                <p><strong>Genre:</strong> {$row['genre']}</p>
                                <p><strong>Book No:</strong> {$row['book_number']}</p>
                                
                                <form method='POST' action='unarchive-book.php'>
                                    <input type='hidden' name='book_id' value='{$row['book_id']}'>
                                    <button type='submit' class='btn btn-success' style='width: 90%;font-size:12.5px;margin-auto;'>Unarchive</button>
                                </form>
                            </div>";
                        }
                    } else {
                        echo "<p>No archived books found.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Show Add Book Modal on Button Click
    document.getElementById('addBookBtn').addEventListener('click', function() {
        var addBookModal = new bootstrap.Modal(document.getElementById('addBookModal'));
        addBookModal.show();
    });

    setTimeout(function() {
        var message = document.getElementById("successMessage");
        if (message) {
            message.style.display = "none";//Hides message after 3 seconds
        }
    }, 3000);

</script>
