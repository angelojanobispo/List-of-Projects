<?php

session_start();

require('./database.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM StudentsInfo";
$result = $conn->query($sql);

// Handle edit request
$editData = [];
if (isset($_GET['edit']) && isset($_GET['libraryid'])) {
    $libraryid = $_GET['libraryid'];
    $edit_sql = "SELECT * FROM StudentsInfo WHERE LibraryID = ?";
    $stmt = $conn->prepare($edit_sql);
    $stmt->bind_param("i", $libraryid);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $libraryid = $_POST['libraryid'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Delete references in timerecords table
        $stmt = $conn->prepare("DELETE FROM TimeRecords WHERE LibraryID = ?");
        $stmt->bind_param("s", $libraryid);
        $stmt->execute();

        // Delete the student record from studentsinfo table
        $stmt = $conn->prepare("DELETE FROM StudentsInfo WHERE LibraryID = ?");
        $stmt->bind_param("s", $libraryid);
        $stmt->execute();

        // Commit transaction
        $conn->commit();
        $_SESSION['success'] = "Record deleted successfully";
    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        $_SESSION['error'] = "Error deleting record: " . $exception->getMessage();
    }

    header("Location: student.php");
    exit();
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <!-- Boxicons -->
    <title>Student Record</title>

    <!-- Bootstrap (Optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
    .alert-container {
        width: 45%;
        text-align: center; /* Center the alert container */
        margin-bottom: 50px; /* Space below the alert container */
        min-height: 10px; /* Reserve space for the alert message */
        position: relative; /* For positioning the alert message */
        margin-top: -20px;
    }

    .alert {
        display: inline-block; /* Make the alert adjust its width based on content */
        padding: 1px; /* Reduced padding */
        margin-bottom: 10px; /* Reduced margin-bottom */
        border: 1px solid transparent;
        border-radius: 4px;
        text-align: center; /* Center the text within the alert */
        max-width: 100%; /* Ensure it doesn't exceed container width */
        margin: 10px auto; /* Center the alert within its container */
        font-size: 20px; /* Increased font size */
        position: absolute; /* Position within the reserved space */
        top: 10%; /* Align to the top of the container */
        left: 50%; /* Center horizontally */
        transform: translateX(-50%); /* Center alignment adjustment */
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-error {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .add-user-btn {
        position: absolute;
        top: 2%; /* Adjust this value to lower or raise the button */
        right: 10%;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .add-user-btn:hover {
        background-color: #45a049;
    }

    .edit-btn,
    .delete-btn {
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .edit-btn {
        background-color: #4CAF50;
        color: white;
        margin-right: 5px;
    }

    .edit-btn:hover {
        background-color: #45a049;
    }

    .delete-btn {
        background-color: #f44336;
        color: white;
    }

    .delete-btn:hover {
        background-color: #d32f2f;
    }

    .table-container {
        max-height: 400px; 
        overflow-y: auto; 
        overflow-x: hidden; 
        border: 3px solid #45a049; 
        position: relative; 
        margin: 1rem 0 0 0;
        border-radius: 10px;
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
        padding: 4px;
        border: 1px solid #ddd;
        text-align: left;
        white-space: nowrap; /* Prevent text wrapping */
        background-color: white;
        font-size: 13px;
    }

    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 2; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        padding-top: 60px;
        box-sizing: border-box; /* Add this line to include padding in width/height */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto; /* 5% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 90%; /* Adjust the width to make it more responsive */
        max-width: 600px;
        border-radius: 8px;
        box-sizing: border-box; /* Add this line */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input, .form-group select {
        width: 100%; /* Make the dropdowns same width as inputs */
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .link-button {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;
    }

    .link-button:hover {
        background-color: #45a049;
    }

    .modal-content h2 {
        text-align: center;
    }

    /* Success Message Modal */
    #successModal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 50%; /* Center horizontally */
        top: 20%; /* Lower position */
        transform: translate(-50%, -20%); /* Translate to center */
        width: 50%; /* Adjust width */
        max-width: 400px;
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        border-radius: 8px;
    }

    #successModal .modal-content {
        background-color: #fefefe;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 8px;
        text-align: center;
    }

    #successModal .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        margin-right: 19px;
    }

    #successModal .close:hover,
    #successModal .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-success {
        display:absolute;
        margin-top: -6%;
        margin-left: 87%;
    }

    .students {
        height: 80vh;
        background-color: white;
        padding: 1rem;
        display: flex;
        flex-direction: column;
    }

    .search-form {
        width: 425px;
        display: flex;
        flex-wrap: nowrap;
        gap: 10px;
        align-items: center;
    }

    .search-form input {
        width: 200px;
        padding: 8px;
        font-size: 16px;
    }

    .search-form button {
        width: 100px;
        padding: 8px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }
    

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
                    <div class="nav-item active">
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
        
        <div class="students" id="div-students">
            <div class="students-header">
                <div class="students-left">
                    <h2 class="title-students">Students Record</h2>
                </div>

                <div class="alert-container">
                    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
                        <div class="alert <?php echo isset($_SESSION['success']) ? 'alert-success' : 'alert-error'; ?>" id="alertMessage">
                        <?php 
                            if (isset($_SESSION['success'])) {
                                echo $_SESSION['success']; 
                                unset($_SESSION['success']);
                            }
                            if (isset($_SESSION['error'])) {
                                echo $_SESSION['error']; 
                                unset($_SESSION['error']);
                            }
                        ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="students-right">
                    <a href="dashboard.php" id="home-link">Home</a>
                    <h1 class="students-nav">/ Students Record</h1>
                </div>
            </div>
            <hr class="header-line">
            <form method="POST" action="" class="search-form">
                <div class="form-group">
                    <input type="text" name="searchQuery" placeholder="Search Student" required>
                    <button type="submit" class="search">Search</button>
                    <button type="button" id="resetBtn" class="reset-btn">Reset</button>
                </div>
            </form>
            <button type="button" class="btn btn-success" class="add-user-btn" id="addUserBtn">ADD USER</button>
            <!-- Table Container for scrollable table -->
<?php
    //If reset button is clicked, show all records
    if (isset($_POST['reset'])) {
        $sql = "SELECT * FROM StudentsInfo";
        $stmt = $conn->prepare($sql);
    } elseif ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['searchQuery'])) {
        $searchTerm = $_POST['searchQuery'] . "%"; // Matches words starting with searchQuery

        $sql = "SELECT * FROM StudentsInfo 
                WHERE StudentNumber LIKE ? 
                OR LastName LIKE ? 
                OR FirstName LIKE ? 
                OR Course LIKE ? 
                OR Section LIKE ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    } else {
        // If no search or reset, show full table
        $sql = "SELECT * FROM StudentsInfo";
        $stmt = $conn->prepare($sql);
    }

$stmt->execute();
$result = $stmt->get_result();
?>

<!--Existing Table -->
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Library ID</th>
                <th>Student Number</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Initial</th>
                <th>Course</th>
                <th>Year & Section</th>
                <th>Edit / Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['LibraryID']}</td>
                            <td>{$row['StudentNumber']}</td>
                            <td>{$row['LastName']}</td>
                            <td>{$row['FirstName']}</td>
                            <td>{$row['MiddleInitial']}</td>
                            <td>{$row['Course']}</td>
                            <td>{$row['Section']}</td>
                            <td>
                                <button class='edit-btn' data-id='{$row['LibraryID']}'>Edit</button>
                                <button class='delete-btn' data-id='{$row['LibraryID']}'>Delete</button>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
$stmt->close();
$conn->close();
?>
        </div>
            <!-- Add User Modal -->
            <div id="myModal" class="modal" >
                <div class="modal-content">
                    <div class="Space">
                        <span class="close">&times;</span>
                    </div>
                    <h2>Sign Up</h2>
                    <form action="signup_process.php" method="post">
                        <div class="form-group">
                            <label for="student_number">Student Number:</label>
                            <input type="number" id="student_number" name="studentnumber" placeholder="Enter your student number" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="lastname" placeholder="Enter your last name" pattern="[A-Za-z ]+" required>
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="firstname" placeholder="Enter your first name" pattern="[A-Za-z ]+" required>
                        </div>
                        <div class="form-group">
                            <label for="middle_initial">Middle Initial:</label>
                            <input type="text" id="middle_initial" name="middleinitial" required maxlength="1" placeholder="Enter your middle initital" pattern="[A-Za-z ]+" required>
                        </div>
                        <div class="form-group">
                            <label for="course">Course:</label>
                            <select id="course" name="course" required>
                                <option value="">Select Course</option>
                                <option value="BSCS">Bachelor of Science in Computer Science</option>
                                <option value="BSIT">Bachelor of Science in Information Technology</option>
                                <option value="BSBA">Bachelor of Science in Business Admnistration</option>
                                <option value="BSHM">Bachelor of Science in Hospitality Management</option>
                                <option value="BSOA">Bachelor of Science in Office Administration</option>
                                <option value="BSP">Bachelor of Science in Pyschology</option>
                                <option value="BSE">Bachelor of Science in Enterpreneurship</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="section">Year&Section:</label>
                            <select id="section" name="section" required>
                                <option value="">Select Year&Section</option>
                                <option value="1A">1A</option>
                                <option value="2A">2A</option>
                                <option value="3A">3A</option>
                                <option value="4A">4A</option>
                                <option value="1B">1B</option>
                                <option value="2B">2B</option>
                                <option value="3B">3B</option>
                                <option value="4B">4B</option>
                                <option value="1C">1C</option>
                                <option value="2C">2C</option>
                                <option value="3C">3C</option>
                                <option value="4C">4C</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" placeholder="Enter your address" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="link-button">Submit</button>
                    </form>
                </div>
            </div>

            <!-- Edit User Form -->
            <?php if (!empty($editData)): ?>
                <div id="editModal" class="modal" style="display: block;">
                    <div class="modal-content">
                        <div class="space">
                            <span class="close" id="editCloseBtn">&times;</span>
                        </div>
                        <h2>Edit Student Info</h2>
                        <form action="signup_process.php" method="post">
                            <input type="hidden" id="editLibraryID" name="libraryid" value="<?php echo $editData['LibraryID']; ?>">
                            <div class="form-group">
                                <label for="editStudentNumber">Student Number:</label>
                                <input type="text" id="editStudentNumber" name="studentnumber" value="<?php echo $editData['StudentNumber']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editLastName">Last Name:</label>
                                <input type="text" id="editLastName" name="lastname" value="<?php echo $editData['LastName']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editFirstName">First Name:</label>
                                <input type="text" id="editFirstName" name="firstname" value="<?php echo $editData['FirstName']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editMiddleInitial">Middle Initial:</label>
                                <input type="text" id="editMiddleInitial" name="middleinitial" required maxlength="1"  value="<?php echo $editData['MiddleInitial']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editCourse">Course:</label>
                                <select id="editCourse" name="course" required>
                                    <option value="">Select Course</option>
                                    <option value="BSCS" <?php if($editData['Course'] == 'BSCS') echo 'selected'; ?>>Bachelor of Science in Computer Science</option>
                                    <option value="BSIT" <?php if($editData['Course'] == 'BSIT') echo 'selected'; ?>>Bachelor of Science in Information Technology</option>
                                    <option value="BSBA" <?php if($editData['Course'] == 'BSBA') echo 'selected'; ?>>Bachelor of Science in Business Administration</option>
                                    <option value="BSHM" <?php if($editData['Course'] == 'BSHM') echo 'selected'; ?>>Bachelor of Science in Hospitality Management</option>
                                    <option value="BSOA" <?php if($editData['Course'] == 'BSOA') echo 'selected'; ?>>Bachelor of Science in Office Administration</option>
                                    <option value="BSP" <?php if($editData['Course'] == 'BSP') echo 'selected'; ?>>Bachelor of Science in Pyschology</option>
                                    <option value="BSE" <?php if($editData['Course'] == 'BSE') echo 'selected'; ?>>Bachelor of Science in Enterpreneurship</option>
                                    
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editSection">Section:</label>
                                <select id="editSection" name="section" required>
                                    <option value="">Select Year&Section</option>
                                    <option value="1A" <?php if($editData['Section'] == '1A') echo 'selected'; ?>>1A</option>
                                    <option value="2A" <?php if($editData['Section'] == '2A') echo 'selected'; ?>>2A</option>
                                    <option value="3A" <?php if($editData['Section'] == '3A') echo 'selected'; ?>>3A</option>
                                    <option value="4A" <?php if($editData['Section'] == '4A') echo 'selected'; ?>>4A</option>
                                    <option value="1B" <?php if($editData['Section'] == '1B') echo 'selected'; ?>>1B</option>
                                    <option value="2B" <?php if($editData['Section'] == '2B') echo 'selected'; ?>>2B</option>
                                    <option value="3B" <?php if($editData['Section'] == '3B') echo 'selected'; ?>>3B</option>
                                    <option value="4B" <?php if($editData['Section'] == '4B') echo 'selected'; ?>>4B</option>
                                    <option value="1C" <?php if($editData['Section'] == '1C') echo 'selected'; ?>>1C</option>
                                    <option value="2C" <?php if($editData['Section'] == '2C') echo 'selected'; ?>>2C</option>
                                    <option value="3C" <?php if($editData['Section'] == '3C') echo 'selected'; ?>>3C</option>
                                    <option value="4C" <?php if($editData['Section'] == '4C') echo 'selected'; ?>>4C</option>

                                    
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editAddress">Address:</label>
                                <input type="text" id="editAddress" name="address" value="<?php echo $editData['Address']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editPassword">Password:</label>
                                <input type="password" id="editPassword" name="password" value="<?php echo $editData['Password']; ?>" required>
                            </div>
                            <button type="submit" class="link-button">Save Changes</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the modals
            var addModal = document.getElementById("myModal");
            var editModal = document.getElementById("editModal");

            // Get the button that opens the add user modal
            var addUserBtn = document.getElementById("addUserBtn");

            // Get the <span> elements that close the modals
            var closeElements = document.querySelectorAll(".modal .close");

            // When the user clicks the button, open the add user modal
            addUserBtn.onclick = function() {
                addModal.style.display = "block";
            };

            // When the user clicks on <span> (x), close the modal
            closeElements.forEach(function(span) {
                span.onclick = function() {
                    span.closest(".modal").style.display = "none";
                };
            });

            // When the user clicks anywhere outside of a modal, close it
            window.onclick = function(event) {
                if (event.target == addModal) {
                    addModal.style.display = "none";
                }
                if (event.target == editModal) {
                    editModal.style.display = "none";
                }
            };

            // Handle edit button click
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                        var libraryid = this.getAttribute('data-id');
                        window.location.href = 'student.php?edit=true&libraryid=' + libraryid;
                    
                });
            });
            // Handle delete button click
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm("Are you sure you want to delete this record?")) {
                        var libraryid = this.getAttribute('data-id');
                        var form = document.createElement('form');
                        form.method = 'post';
                        form.action = 'student.php';
                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'action';
                        input.value = 'delete';
                        form.appendChild(input);

                        var inputId = document.createElement('input');
                        inputId.type = 'hidden';
                        inputId.name = 'libraryid';
                        inputId.value = libraryid;
                        form.appendChild(inputId);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });

            // Hide alert messages after 4 seconds
            setTimeout(function() {
                var alertMessage = document.getElementById('alertMessage');
                if (alertMessage) {
                    alertMessage.style.display = 'none';
                }
            }, 4000);
        });
    </script>

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
    <script>
        document.getElementById("resetBtn").addEventListener("click", function() {
            window.location.href = window.location.pathname; // ✅ Reloads the current page
        });
    </script>



</body>
</html>

