<?php
require('./database.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the most recent time records for each student and determine if they are active or not active
$sql = "
SELECT 
    StudentsInfo.LibraryID, 
    IF(tr.TimeIn IS NOT NULL AND tr.TimeOut IS NULL, 'Active', 'Not Active') AS Status
FROM 
    StudentsInfo
LEFT JOIN (
    SELECT 
        LibraryID, TimeIn, TimeOut
    FROM 
        TimeRecords
    WHERE 
        (LibraryID, TimeIn) IN (
            SELECT 
                LibraryID, MAX(TimeIn)
            FROM 
                TimeRecords
            GROUP BY 
                LibraryID
        )
) tr ON StudentsInfo.LibraryID = tr.LibraryID";

$result = $conn->query($sql);

$activeCount = 0;
$notActiveCount = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['Status'] === 'Active') {
            $activeCount++;
        } else {
            $notActiveCount++;
        }
    }
}

// Fetch the number of students
$query_students = "SELECT COUNT(*) as total_students FROM studentsinfo";
$result_students = mysqli_query($conn, $query_students);
$data_students = mysqli_fetch_assoc($result_students);
$total_students = $data_students['total_students'];

// Fetch the number of books
$query_books = "SELECT COUNT(*) as total_books FROM books WHERE archived='NO'";
$result_books = mysqli_query($conn, $query_books);
$data_books = mysqli_fetch_assoc($result_books);
$total_books = $data_books['total_books'];


// Get the total number of computers (i.e., entries in computer_assignments table)
$sql_computers = "SELECT COUNT(*) AS total_computers FROM computer_assignments";
$result_computers = $conn->query($sql_computers);
$total_computers = 0;
if ($result_computers->num_rows > 0) {
    $row = $result_computers->fetch_assoc();
    $total_computers = $row['total_computers'];
}

// Get the total number of computer users (where a name is assigned)
$sql_computer_users = "SELECT COUNT(DISTINCT computer_id) AS total_computer_users FROM computer_assignments WHERE name != ''";  
$result_computer_users = $conn->query($sql_computer_users);
$total_computer_users = 0;
if ($result_computer_users->num_rows > 0) {
    $row = $result_computer_users->fetch_assoc();
    $total_computer_users = $row['total_computer_users'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Dashboard</title>
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
                    <div class="nav-item active">
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
                    <div class="nav-item">
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

            <div class="dashboard" id="div-dashboard">
                <div class="dashboard-header">
                    <div class="dashboard-left">
                        <h2 class="title-dashboard">Dashboard</h2>
                    </div>
                    <div class="dashboard-right">
                        <a href="dashboard.php" id="home-link">Home</a>
                        <h1 class="dashboard-nav">/ Dashboard</h1>
                    </div>
                </div>
                <hr class="header-line">

                <div class="stats-container">
                    <div class="stat-card">
                        <h3>Students</h3>
                        <h2><?php echo $total_students; ?></h2>
                        <div class="view-info">
                            <a href="student.php">
                                <box-icon name='search-alt-2'></box-icon>
                            </a>
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Active Users</h3>
                        <h2><?php echo $activeCount; ?></h2>
                        <div class="view-info">
                            <a href="in-library.php">
                                <box-icon name='search-alt-2'></box-icon>
                            </a>
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Not Active Users</h3>
                        <h2><?php echo $notActiveCount; ?></h2>
                        <div class="view-info">
                            <a href="in-library.php">
                                <box-icon name='search-alt-2'></box-icon>
                            </a>
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Books</h3>
                        <h2><?php echo $total_books; ?></h2>
                        <div class="view-info">
                            <a href="book.php">
                                <box-icon name='search-alt-2'></box-icon>
                            </a>
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Computers</h3>
                        <h2><?php echo $total_computers; ?></h2>
                        <div class="view-info">
                            <a href="computer.php">
                                <box-icon name='search-alt-2'></box-icon>
                            </a>
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Computer Users</h3>
                        <h2><?php echo $total_computer_users; ?></h2>
                        <div class="view-info">
                            <a href="computer.php">
                                <box-icon name='search-alt-2'></box-icon>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js" defer></script>
    <script src="script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
