<?php
session_start();

if (!empty($_SESSION['ShowWelcomeModal'])): ?>
    <script>
        sessionStorage.setItem("ShowWelcomeModal", "true"); // Ensures modal opens once
    </script>
    <?php unset($_SESSION['ShowWelcomeModal']); // Prevents re-triggering ?>
<?php endif; ?>


<!DOCTYPE html>
<html>
<head>
    <title>Library</title>
    <link rel="stylesheet" href="style.css">
</head>
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
            background: url('image/background-img.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .nav-main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 15vh;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 2rem;
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
            display: none;
        }
        .success {
            background-color: #4CAF50;
        }
        .Invalid {
            background-color: #f44336;
        }
        .submit-btn{
            background-color: #45a049;
        }
        .submit-btn:hover{
            background-color: #4CAF50;
        }

        .add-new-user-btn{
            margin-top: 5rem;
            margin-left: 44.5%;
            background-color: #45a049
        }
        .add-new-user-btn:hover{
            background-color: #4CAF50;
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
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
    box-sizing: border-box; /* Ensures padding fits */
}

.modal-content {
    background-color: #fefefe;
    margin: auto; /* Centering dynamically */
    padding: 20px;
    border: 1px solid #888;
    width: 90%;
    max-width: 600px;
    border-radius: 8px;
    box-sizing: border-box; /* Includes padding */
    text-align: center;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    text-align: left; /* Aligns label to the left */
    margin-bottom: 5px; /* Adds spacing below the label */
}

.form-group-sign label {
    display: block;
    text-align: left; /* Aligns label to the left */
    margin-bottom: 5px; /* Adds spacing below the label */
}

.form-group input, .form-group select {
    width: 100%; /* Makes fields consistent */
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


    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const messageBox = document.getElementById("message-box");
            if (messageBox && messageBox.innerText.trim() !== "") {
                messageBox.style.display = "block";
                setTimeout(() => messageBox.style.display = "none", 5000);
            }
        });
    </script>

    <div class="container">
        <div class="container-form">
            <!-- Corrected Message Box Handling -->
            <?php if (!empty($_SESSION['Message']) || !empty($_SESSION['Invalid'])): ?>
                <div id="message-box" class="message-box 
                    <?php echo (!empty($_SESSION['MessageType']) && ($_SESSION['MessageType'] == 'timein' || $_SESSION['MessageType'] == 'timeout')) ? 'success' : (!empty($_SESSION['Invalid']) ? 'Invalid' : ''); ?>">
    
                <?php 
                if (!empty($_SESSION['Message'])) { 
                    echo $_SESSION['Message']; 
                    unset($_SESSION['Message']);
                    unset($_SESSION['MessageType']);
                } elseif (!empty($_SESSION['Invalid'])) { 
                    echo $_SESSION['Invalid']; 
                    unset($_SESSION['Invalid']); 
                }
                ?>
                
</div>

            <?php endif; ?>

            <form action="timelog_process.php" method="post">
                <div class="form-group">
                    <label for="libraryid">Library ID:</label>
                    <input type="text" id="libraryid" name="libraryid" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="submitbutton">
                    <button type="submit" class="submit-btn" name="submit">Submit</button>
                </div>
            </form>


        </div>
    </div>

    <button type="button" class="add-new-user-btn" class="btn btn-success" id="addUserBtn"><p>New Students?</p>Click Here<p></button>

<!-- Sign-Up Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="Space">
            <span class="close">&times;</span>
        </div>
        <div></div>
        <h2>Sign Up</h2>
        <div style="height: 20px;"></div>
        <form action="signup_process_student.php" method="post">
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
<!-- Welcome Modal -->
<div id="welcomeModal" class="modal">
    <div class="modal-content">
        <span id="closeWelcomeModal" class="close">&times;</span>
        <h2>Account Created Successfully!</h2>

        <?php
        if (!empty($_SESSION['SuccessMessage'])) { 
            echo "<div class='success-message'>" . $_SESSION['SuccessMessage'] . "</div>"; 
            
            // Remove message after displaying it
            unset($_SESSION['SuccessMessage']);
            unset($_SESSION['ShowWelcomeModal']);
        }
        ?>
        </p>
        <button id="closeModalBtn" class="link-button">Okay</button>
    </div>
</div>

</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("addUserBtn");
    var closeBtn = document.querySelector(".close");

    // Open the modal when clicking the button
    btn.onclick = function() {
        modal.style.display = "block";
    };

    // Close the modal when clicking the "×" button
    closeBtn.onclick = function() {
        modal.style.display = "none";
    };

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
});

document.addEventListener("DOMContentLoaded", function() {
    var welcomeModal = document.getElementById("welcomeModal");
    var closeWelcomeModal = document.getElementById("closeWelcomeModal");
    var closeModalBtn = document.getElementById("closeModalBtn");

    <?php if (!empty($_SESSION['ShowWelcomeModal'])): ?>
        sessionStorage.setItem("ShowWelcomeModal", "true"); // Ensures modal opens again
    <?php endif; ?>

    if (sessionStorage.getItem("ShowWelcomeModal") === "true") {
        welcomeModal.style.display = "block"; 
        console.log("Welcome modal opened!");
    }

    // Close modal and reset session for future openings
    if (closeWelcomeModal) {
        closeWelcomeModal.onclick = function() {
            welcomeModal.style.display = "none";
            sessionStorage.removeItem("ShowWelcomeModal"); // Completely resets modal state
        };
    }
    if (closeModalBtn) {
        closeModalBtn.onclick = function() {
            welcomeModal.style.display = "none";
            sessionStorage.removeItem("ShowWelcomeModal");
        };
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target === welcomeModal) {
            welcomeModal.style.display = "none";
            sessionStorage.removeItem("ShowWelcomeModal");
        }
    };
});
</script>



</html>
