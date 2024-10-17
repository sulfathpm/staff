<?php
// Start the session
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'fashion'; // Replace with your database name
$user = 'root'; // Replace with your database username  
$pass = ''; // Replace with your database password

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Redirect if the user is not logged in
if (!isset($_SESSION["USER_ID"])) {
    echo "<script>
            alert('You need to login to view this page.');
            window.location.href = 'login.php';
          </script>";
    exit(); // Terminate the script after redirection
}

// Get the logged-in staff's USER_ID
$staff_id = $_SESSION["USER_ID"];

// Retrieve measurements for orders assigned to the logged-in staff member
$sql = "SELECT m.MEASUREMENT_ID, m.USER_ID, m.DRESS_ID, m.FABRIC_ID, m.SHOULDER, m.BUST, m.WAIST, m.HIP, m.CREATED_AT 
        FROM measurements m
        INNER JOIN order_assignments oa ON m.DRESS_ID = oa.ORDER_ID
        WHERE oa.STAFF_ID = :staff_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':staff_id' => $staff_id]);
$measurements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Measurements</title>
    <link rel="stylesheet" href="staff1.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
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

        .table-container {
            padding: 0 20px; /* Adds padding to both left and right sides of the table */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }

        /* Optional styling for mobile responsiveness */
        @media screen and (max-width: 768px) {
            .table-container {
                padding: 0 10px; /* Reduce padding on smaller screens */
            }
            table, th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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

    <div class="table-container">
        <h3>Assigned Measurements</h3>
        <table>
            <thead>
                <tr>
                    <th>Measurement ID</th>
                    <th>User ID</th>
                    <th>Dress ID</th>
                    <th>Fabric ID</th>
                    <th>Shoulder</th>
                    <th>Bust</th>
                    <th>Waist</th>
                    <th>Hip</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($measurements)): ?>
                    <?php foreach ($measurements as $measurement): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($measurement['MEASUREMENT_ID']); ?></td>
                            <td><?php echo htmlspecialchars($measurement['USER_ID']); ?></td>
                            <td><?php echo htmlspecialchars($measurement['DRESS_ID']); ?></td>
                            <td><?php echo htmlspecialchars($measurement['FABRIC_ID']); ?></td>
                            <td><?php echo htmlspecialchars($measurement['SHOULDER']); ?></td>
                            <td><?php echo htmlspecialchars($measurement['BUST']); ?></td>
                            <td><?php echo htmlspecialchars($measurement['WAIST']); ?></td>
                            <td><?php echo htmlspecialchars($measurement['HIP']); ?></td>
                            <td><?php echo htmlspecialchars($measurement['CREATED_AT']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9">No measurements assigned to you.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
