<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Computer Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            display:flex;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .computer-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 50px;
            margin: auto;
            text-align: center;
            background-color: #fafafa;
        }
        .countdown {
            margin-top: 5px;
            font-weight: bold;
        }
        #assignFormContainer {
            display: none; 
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-title {
            margin: 0;
            font-size: 1.5em;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            border-radius: 4px;
            border: none;
        }
        .btn-success {
            background-color: #00964F;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-close {
            background-color: transparent;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
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
                    <div class="nav-item">
                        <box-icon name='library' color="white"></box-icon>
                        <a href="in-library.php" id="in-library" class="nav-link">In-Library</a>
                    </div>
                </li>
                <li>
                    <div class="nav-item active">
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
                        <h2 class="title-dashboard">Computer Management</h2>
                    </div>
                    <div class="dashboard-right">
                        <a href="dashboard.php" id="home-link">Home</a>
                        <h1 class="dashboard-nav">/ Dashboard</h1>
                    </div>
                </div>
                <hr class="header-line">

                <!-- Computers List from the first piece of code -->
                <div class="container">
                    <div class="computer-card" id="computer1">
                        <h3>PC No: 1</h3>
                        <p id="computer1-id"></p>
                        <p class="countdown" id="computer1-timer"></p>
                        <button class="btn btn-success" onclick="showForm('1')">Assign</button>
                        <button class="btn btn-delete" onclick="clearAssignment('1')">Delete</button>
                    </div>
                    <div class="computer-card" id="computer2">
                        <h3>PC No: 2</h3>
                        <p id="computer2-id"></p>
                        <p class="countdown" id="computer2-timer"></p>
                        <button class="btn btn-success" onclick="showForm('2')">Assign</button>
                        <button class="btn btn-delete" onclick="clearAssignment('2')">Delete</button>
                    </div>
                </div>

                <!-- Hidden Form from the first piece of code -->
                <div id="assignFormContainer">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign Name</h5>    
                            <button type="button" class="btn-close" aria-label="Close" onclick="hideForm()"></button>
                        </div>
                        <div class="modal-body">
                        <form id="assignForm" onsubmit="submitForm(event)">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" pattern="[A-Za-z ]+" placeholder="Enter your name" required>
                                </div>
                                <input type="hidden" id="computerId">
                                <button type="submit" class="btn btn-success">Assign</button>
                            </form>
                        </div>
                    </div>
                </div>

                                <!-- JavaScript for logic -->
                                <script>
                    const timers = {}; // Object to store timer references

                    function showForm(id) {
                        document.getElementById('computerId').value = id;
                        document.getElementById('assignFormContainer').style.display = 'block';
                    }

                    function hideForm() {
                        document.getElementById('assignFormContainer').style.display = 'none';
                    }

                    function submitForm(event) {
                        event.preventDefault();

                        const computerId = document.getElementById('computerId').value;
                        const name = document.getElementById('name').value;

                        // Send data to the server
                        fetch('computer-assign.php', {  // Ensure this points to the correct PHP file
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `computerId=${computerId}&name=${encodeURIComponent(name)}`
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert(data);
                            document.getElementById(`computer${computerId}-id`).innerText = `Name: ${name}`;
                            hideForm();
                            localStorage.setItem(`computer${computerId}-name`, name);
                            localStorage.setItem(`computer${computerId}-startTime`, new Date().getTime());
                        })
                        .catch(error => {
                            alert('Error: ' + error);
                        });
                    }

                    function clearAssignment(computerId) {
                        document.getElementById(`computer${computerId}-id`).innerText = '';
                        document.getElementById(`computer${computerId}-timer`).innerText = '';
                        localStorage.removeItem(`computer${computerId}-name`);
                        localStorage.removeItem(`computer${computerId}-startTime`);

                        if (timers[computerId]) {
                            clearInterval(timers[computerId]);
                        }
                            // Send delete request to the server to remove the assignment from the database
                            fetch('computer-delete.php', {  // Update the PHP file name here
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `computerId=${computerId}`
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log(data); // Optionally log the response
                            })
                            .catch(error => {
                                alert('Error: ' + error);
                            });
                    }

                    function startCountdown(elementId, startTime, computerId) {
                        const countdownElement = document.getElementById(elementId);
                        const endTime = startTime + 3600000;

                        timers[computerId] = setInterval(() => {
                            const currentTime = new Date().getTime();
                            let timeLeft = (endTime - currentTime) / 1000;

                            if (timeLeft <= 0) {
                                clearInterval(timers[computerId]);
                                countdownElement.innerText = '';
                                document.getElementById(`computer${computerId}-id`).innerText = ``;
                            } else {
                                const minutes = Math.floor(timeLeft / 60);
                                const seconds = Math.floor(timeLeft % 60);
                                countdownElement.innerText = `${minutes}m ${seconds}s`;
                            }
                        }, 1000);
                    }

                    function loadAssignments() {
                        const computers = [1, 2];
                        computers.forEach(computerId => {
                            const name = localStorage.getItem(`computer${computerId}-name`);
                            const startTime = parseInt(localStorage.getItem(`computer${computerId}-startTime`), 10);

                            if (name && startTime) {
                                document.getElementById(`computer${computerId}-id`).innerText = `Name: ${name}`;
                                startCountdown(`computer${computerId}-timer`, startTime, computerId);
                            }
                        });
                    }

                    window.onload = loadAssignments;
                </script>

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>