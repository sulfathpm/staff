<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="staff.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .header {
            background-color: #4a4e69;
            color: #fff;
            padding: 15px;
            text-align: center;
            font-size: 2em;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .staff-dashboard {
            text-align: center;
        }

        .navbar {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
            background-color: #22223b;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h3 {
            color: #f2e9e4;
            margin-bottom: 20px;
            font-size: 2em;
        }

        .navbar a {
            color: #f2e9e4;
            text-decoration: none;
            font-size: 1.5em;
            padding: 15px 25px;
            margin: 10px 0;
            background-color: #4a4e69;
            border-radius: 10px;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s, transform 0.2s;
        }

        .navbar a:hover {
            background-color: #9a7bba;
            transform: translateY(-2px);
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .navbar {
                width: 90%;
                padding: 20px;
            }

            .navbar a {
                font-size: 1.2em;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Staff Dashboard</h1>
    </div>

    <div class="staff-dashboard">
        <div class="navbar">
            <a href="staffdshbrd.php">Home</a>
            <a href="ManageOrder.php">Orders</a>
            <a href="measurement.php">Measurement</a>
            <?php
            // Check if the user is logged in
            if (!isset($_SESSION["USER_ID"])) {
                echo "<a href='login.php'>Login</a>";
            } else {
                echo "<a href='logout.php'>Logout</a>"; // Change to Logout if user is logged in
                echo "<a href='staff_profile.php'>Profile</a>";
            }
            ?>
        </div>
    </div>
</body>
</html>
