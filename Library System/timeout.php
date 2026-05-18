<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library</title>
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
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
        height: 15vh; /* Full viewport height for vertical centering */
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 5rem;
        }
        .container-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .message-box {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            color: #fff;
            display: none; /* Hidden by default */
        }
        .success, .goodbye-message {
            background-color: #4CAF50;
        }
        .Invalid {
            background-color: #f44336;
        }
        .goodbye-message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            color: #fff;
            background-color: #4CAF50; /* Green background for goodbye message */
            display: none; /* Hidden by default */
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
        .timeout-button {
            border: 3px solid #FFC107;  /* Same color as the "Time In" button */
        }
        .submitbutton{
            align-items: center;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const messageBox = document.getElementById("message-box");
            const goodbyeMessage = document.getElementById("goodbye-message");
            if (messageBox.innerText !== "") {
                messageBox.style.display = "block";
                setTimeout(function() {
                    messageBox.style.display = "none";
                }, 5000);
            }
            if (goodbyeMessage.innerText !== "") {
                goodbyeMessage.style.display = "block";
                setTimeout(function() {
                    goodbyeMessage.style.display = "none";
                }, 5000);
            }
        });
    </script>
</head>
<body>
    <div class="container">
    <div class="container-form">
        <div id="message-box" class="message-box <?php echo isset($_SESSION['message']) ? 'success' : (isset($_SESSION['Invalid']) ? 'Invalid' : ''); ?>">
            <?php
            if (isset($_SESSION['Invalid'])) {
                echo $_SESSION['Invalid'];
                unset($_SESSION['Invalid']);
            }
            ?>
        </div>
        <?php if (isset($_SESSION['username'])): ?>
            <div id="goodbye-message" class="goodbye-message">
                Goodbye, <?php echo $_SESSION['username']; ?>!
            </div>
            <?php unset($_SESSION['username']); ?>
        <?php endif; ?>
        <div class="form-group">
            <a href="timein.php" class="link-button">Time In</a>
            <a href="timeout.php" class="link-button timeout-button">Time Out</a>
        </div>
        <br>
        <form action="timeout_process.php" method="post">
            <div class="form-group">
                <label for="libraryid">Library ID:</label>
                <input type="text" id="libraryid" name="libraryid" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class=submitbutton>
            <button type="submit" name="submit">Submit</button>
            </div>
        </form>
    </div>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js" defer></script>
    <script src="script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
