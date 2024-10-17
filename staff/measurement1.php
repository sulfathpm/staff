<?php
// Start the session and enable error reporting for debugging
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

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
    <link rel="stylesheet" href="staff.css">
</head>
<body>
    <div class="header">
        <h1>Measurements</h1>
    </div>

    <div class="staff-dashboard">
        <aside class="sidebar">
            <h3>Menu</h3>
            <a href="staffdash.html">Dashboard</a>
            <a href="manage-orders.html">Manage Orders</a>
            <a href="pending-orders.html">Pending Orders</a>
            <a href="recent-communications.html">Communication</a> 
            <a href="measurements.php">Measurements</a>
            <a href="#">Material Requirements</a>
        </aside>

        <main class="main-content">
            <section class="card">
                <!-- <h2>Input and Manage Measurements</h2>
                <p>Here you can input and manage customer measurements.</p>
                <form action="measurements.php" method="post" class="measurement-form">
                    <h3>Enter New Measurement</h3>

                    <label for="user-id">User ID:</label>
                    <input type="text" id="user-id" name="user-id" required>

                    <label for="dress-id">Dress ID:</label>
                    <input type="text" id="dress-id" name="dress-id" required>

                    <label for="fabric-id">Fabric ID:</label>
                    <input type="text" id="fabric-id" name="fabric-id" required>

                    <label for="shoulder">Shoulder (in inches):</label>
                    <input type="number" id="shoulder" name="shoulder" step="0.01" required>

                    <label for="bust">Bust (in inches):</label>
                    <input type="number" id="bust" name="bust" step="0.01" required>

                    <label for="waist">Waist (in inches):</label>
                    <input type="number" id="waist" name="waist" step="0.01" required>

                    <label for="hip">Hip (in inches):</label>
                    <input type="number" id="hip" name="hip" step="0.01" required>

                    <button type="submit">Submit</button>
                </form> -->

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
                            <th>order date</th>
                            <!-- <th>Actions</th> -->
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
                            <!-- <td><button>Edit</button></td> -->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
