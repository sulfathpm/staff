<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to MySQL database
$dbcon = mysqli_connect("localhost", "root", "", "fashion");

// Check connection
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the current staff details
$staff_id = $_SESSION['USER_ID'];
if (!isset($staff_id)) {
    die("Staff not logged in.");
}

// Fetch staff details
$stmt = $dbcon->prepare("SELECT * FROM users WHERE USER_ID = ?");
if (!$stmt) {
    die("Prepare failed: " . $dbcon->error);
}
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $staff = $result->fetch_assoc();
} else {
    die("Staff not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7; /* Softer background color */
            margin: 0;
            padding: 0;
            color: #333;
        }
        .navbar {
            background-color: #4a4e69; /* Dark purple */
            padding: 15px 0;
            text-align: center;
        }
        .navbar a {
            color: #fff;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
        }
        .profile-container {
            max-width: 1000px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
            border-radius: 10px; /* Slightly larger border radius */
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .profile-info h2 {
            font-weight: 600;
            color: #22223b; /* Header text color */
        }
        .profile-info p {
            font-size: 16px;
            color: #666;
        }
        .btn-edit {
            padding: 10px 20px;
            background-color: #9a7bba; /* Lavender */
            color: white;
            border: none;
            border-radius: 5px; /* Rounded corners */
            cursor: pointer;
        }
        .btn-edit:hover {
            background-color: #7c4d8b; /* Darker lavender on hover */
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #4a4e69; /* Dark purple */
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .profile-section {
            margin-top: 20px;
        }
        .profile-section h3 {
            color: #22223b;
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .profile-section ul {
            list-style: none;
            padding: 0;
        }
        .profile-section li {
            background-color: #f2e9e4; /* Light beige for list items */
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="staffdshbrd.php">Home</a>
        <a href="ManageOrder.php">Orders</a>
        <a href="measurement.php">Measurement</a>
        <?php
        if (!isset($_SESSION["USER_ID"])) {
            echo "<a href='login.php'>Login</a>";
        } else {
            echo "<a href='logout.php'>Logout</a>";
            echo "<a href='staff_profile.php'>Profile</a>";
        }
        ?>
    </div>

    <div class="profile-container">
        <div class="profile-header">
            <?php if (!empty($staff['PROFILE_PICTURE'])): ?>
                <img src="<?php echo htmlspecialchars($staff['PROFILE_PICTURE']); ?>" alt="Profile Picture">
            <?php else: ?>
                <img src="https://via.placeholder.com/120" alt="Profile Picture">
            <?php endif; ?>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($staff['USERNAME']); ?></h2>
                <p>Email: <?php echo htmlspecialchars($staff['EMAIL']); ?></p>
                <p>Joined on: <?php echo substr($staff['CREATED_AT'], 0, 10); ?></p>
                <button class="btn-edit" onclick="window.location.href='edit_staff_profile.php'">Edit Profile</button>
            </div>
        </div>

        <!-- <div class="profile-section">
            <h3>Allotted Orders</h3>
            <?php
                // Fetch allotted orders from order_assignments table
                $stmt = $dbcon->prepare("
                    SELECT o.ORDER_ID, o.STATUSES, o.CREATED_AT
                    FROM order_assignments oa
                    JOIN orders o ON oa.ORDER_ID = o.ORDER_ID
                    WHERE oa.STAFF_ID = ?
                ");
                if (!$stmt) {
                    die("Prepare failed for order query: " . $dbcon->error);
                }
                $stmt->bind_param("i", $staff_id);
                $stmt->execute();
                $result_orders = $stmt->get_result();

                if ($result_orders && $result_orders->num_rows > 0) {
                    echo "<ul>";
                    while ($order = $result_orders->fetch_assoc()) {
                        echo "<li>Order ID: " . htmlspecialchars($order['ORDER_ID']) . " - Status: " . htmlspecialchars($order['STATUSES']) . " - Created on: " . substr($order['CREATED_AT'], 0, 10) . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No orders allotted to you.</p>";
                }
            ?>
        </div> -->

        <div class="footer">
            <p>&copy; 2024 Fashion Boutique. All Rights Reserved.</p>
        </div>
    </div>

</body>
</html>
