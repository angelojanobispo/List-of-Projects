<?php
session_start();
require('./database.php'); // Ensure correct database connection

// Fetch all records OR filter search results
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['searchQuery'])) {
    $searchTerm = "%" . $_POST['searchQuery'] . "%";
    $sql = "SELECT * FROM StudentsInfo 
            WHERE StudentNumber LIKE ? 
            OR LastName LIKE ? 
            OR FirstName LIKE ? 
            OR Course LIKE ? 
            OR Section LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
} else {
    // Load the full table when no search is performed
    $sql = "SELECT * FROM StudentsInfo";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Existing Table -->
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
