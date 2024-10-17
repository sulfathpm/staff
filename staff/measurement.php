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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user-id']; // Assuming you will pass user ID in the form
    $dress_id = $_POST['dress-id']; // Assuming you will pass dress ID in the form
    $fabric_id = $_POST['fabric-id']; // Assuming you will pass fabric ID in the form
    $shoulder = $_POST['shoulder'];
    $bust = $_POST['bust'];
    $waist = $_POST['waist'];
    $hip = $_POST['hip'];

    // Insert the new measurement into the database
    $sql = "INSERT INTO measurements (USER_ID, DRESS_ID, FABRIC_ID, SHOULDER, BUST, WAIST, HIP) VALUES (:user_id, :dress_id, :fabric_id, :shoulder, :bust, :waist, :hip)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':dress_id' => $dress_id,
        ':fabric_id' => $fabric_id,
        ':shoulder' => $shoulder,
        ':bust' => $bust,
        ':waist' => $waist,
        ':hip' => $hip
    ]);
}

// Retrieve existing measurements
$sql = "SELECT * FROM measurements";
$stmt = $pdo->query($sql);
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

        /* Add padding to both sides of the table */
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
        <h3>Existing Measurements</h3>
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
            </tbody>
        </table>
    </div>
</body>
</html>
