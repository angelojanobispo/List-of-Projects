<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="nav-main">
        <div class="logo">
                <div class="logo-icon">
                    <img src="image/logo.png" alt="" class="icon">
                </div>
                <div class="logo-text">
                    <h2 class="library">LIBRARY</h2>
                    <h2 class="imus-campus">IMUS-CAMPUS</h2>
                </div>
            </div>
     </div>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('image/background-img.jpg') no-repeat center center fixed; /* Set the background image */
            background-size: cover; /* Ensure the image covers the entire area */
            margin: 0;
            padding: 0;

        }
        .nav-main {
            display: flex;
            justify-content: center; 
            align-items: center; /* Center vertically */
            height: 15vh; /* Full viewport height for vertical centering */
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 9rem;
        }
        .container-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        button, .link-button {
            width: 100px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }
        button:hover, .link-button:hover {
            background-color: #45a049;
        }
        .link-button {
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="container-form">
            <form action="admin.php" method="post">
                <div class="form-group">
                    <label for="libraryid">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="submitbutton">
                <button type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js" defer></script>
<script src="script.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php 

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user_admin = "admin";
        $pass_admin = "admin123";

        if($username == $user_admin && $password == $pass_admin ) {
            header('Location: dashboard.php');
        }

        else {
            echo "<script>alert('Incorrect username and password')</script>";
        }
    }

?>
