<?php
    require('./database.php');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the most recent time records for each student
    $sql = "
    SELECT 
        StudentsInfo.LibraryID, 
        StudentsInfo.LastName, 
        StudentsInfo.FirstName, 
        StudentsInfo.MiddleInitial,
        StudentsInfo.Course, 
        StudentsInfo.Section,
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <!-- Boxicons -->
    <title>Library Status</title>

    <!-- Bootstrap (Optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 100%;
            text-align: left;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .totals-container {
            display: flex;
            gap: 30px;
            margin-bottom: 20px;
        }

        .totals {
            background-color: #f2f2f2;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .totals h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .table-container {
            max-height: 300px; 
            overflow-y: auto; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
        background-color: #f9f9f9; /* Optional: Add a background color for header */
        position: sticky; /* Make the header sticky */
        top: 0; /* Stick to the top of the table */
        z-index: 1; /* Ensure it stays above table rows */
        }   

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .status-active {
            background-color: #4CAF50; 
            color: white;
        }

        .status-not-active {
            background-color: #f44336; /* Red for not active */
            color: white;
        }

        .status-cell {
            text-align: center; /* Center text horizontally */
        }

        #active {
            background-color: #f2f2f2;
            color: #4CAF50;
        }
        #not-active {
            background-color: #f2f2f2;
            color:#f44336;
        }
        
        .in-library {
            height: 80vh;
            background-color: white;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

    </style>
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
                    <div class="nav-item">
                        <box-icon name="book-add" type="solid" color="white"></box-icon>
                        <a href="book.php" id="books" class="nav-link">Books</a>
                    </div>
                </li>
                <li>
                    <div class="nav-item active">
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

        <div class="in-library" id="div-inlibrary">
            <div class="library-header">
                <div class="library-left">
                    <h2 class="title-library">Library Users</h2>
                </div>
                <div class="library-right">
                    <a href="dashboard.php" id="home-link">Home</a>
                    <h1 class="library-nav">/ Library Users</h1>
                </div>
            </div>
            <hr class="header-line">

            <div class="container">
                <div class="header">
                    <div class="totals-container">
                        <div class="totals">
                            <h3>Active Users: <span id="active" class="status-active"><?php echo $activeCount; ?></span></h3>
                        </div>
                        <div class="totals">
                            <h3>Not Active Users: <span id="not-active" class="status-not-active"><?php echo $notActiveCount; ?></span></h3>
                        </div>
                    </div>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Library ID</th>
                                <th>Full Name</th>
                                <th>Course</th>
                                <th>Section</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $statusClass = ($row['Status'] == 'Active') ? 'status-active' : 'status-not-active';
                                    
                                    // Count active and not active users
                                    if ($row['Status'] == 'Active') {
                                        $activeCount++;
                                    } else {
                                        $notActiveCount++;
                                    }
                                    echo "<tr>
                                            <td>" . $row['LibraryID'] . "</td>
                                            <td>" . $row['FirstName'] . " " . $row['MiddleInitial'] .". " . $row['LastName'] ."</td>
                                            <td>" . $row['Course'] . "</td>
                                            <td>" . $row['Section'] . "</td>
                                            <td class='status-cell " . $statusClass . "'>" . $row['Status'] . "</td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No records found</td></tr>";
                            }

                            // Display totals
                            echo "<script>
                                document.querySelector('.status-active').textContent = '$activeCount';
                                document.querySelector('.status-not-active').textContent = '$notActiveCount';
                            </script>";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


    <!-- Boxicons Script -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js" defer></script>
    <script src="script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
            document.getElementById('addBookBtn').addEventListener('click', function() {
                var myModal = new bootstrap.Modal(document.getElementById('myModal'));
                myModal.show();
            });
    </script>
</body>
</html>
