<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION["USER_ID"])) {
    // If not logged in, show an alert and redirect to the login page
    echo "<script>
            alert('You need to login to view the page');
            window.location.href = 'login.php'; // Redirect to login page
          </script>";
    exit(); // Stop further execution
}

// Database connection settings
$host = "localhost";  // Your database host
$dbname = "fashion";  // Your database name
$username = "root";  // Your database username
$password = "";  // Your database password

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize a variable for status messages
$statusMessage = "";

// Check if the form is submitted for updating the status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // SQL query to update the order status
    $sql = "UPDATE orders SET STATUSES = ? WHERE ORDER_ID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $status, $order_id);
        if ($stmt->execute()) {
            $statusMessage = "Order status updated successfully!";
        } else {
            $statusMessage = "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch orders assigned to the logged-in staff member from the database
$staff_id = $_SESSION["USER_ID"];
$sql = "SELECT orders.ORDER_ID, users.USER_ID, orders.SSIZE, orders.STATUSES, orders.ESTIMATED_DELIVERY_DATE 
        FROM orders
        INNER JOIN users ON orders.USER_ID = users.USER_ID
        INNER JOIN order_assignments ON orders.ORDER_ID = order_assignments.ORDER_ID
        WHERE order_assignments.STAFF_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
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
        .container {
            padding: 0 20px; /* Add padding on both sides of the container */
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

    <div class="container">
        <h2>Manage Orders</h2>
        
        <?php if ($statusMessage): ?>
            <script>
                alert("<?php echo addslashes($statusMessage); ?>");
            </script>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Size</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['ORDER_ID'] . "</td>";
                        echo "<td>" . $row['USER_ID'] . "</td>";
                        echo "<td>" . $row['SSIZE'] . "</td>";
                        echo "<td id='status-display-" . $row['ORDER_ID'] . "'>" . ucfirst($row['STATUSES']) . "</td>";
                        echo "<td>" . $row['ESTIMATED_DELIVERY_DATE'] . "</td>";

                        // Form for updating status
                        echo "<td>";
                        echo "<form action='' method='post'>";
                        echo "<input type='hidden' name='order_id' value='" . $row['ORDER_ID'] . "'>";
                        echo "<select name='status' required>
                                <option value='pending'" . ($row['STATUSES'] == 'pending' ? " selected" : "") . ">Pending</option>
                                <option value='in-progress'" . ($row['STATUSES'] == 'in-progress' ? " selected" : "") . ">In Progress</option>
                                <option value='completed'" . ($row['STATUSES'] == 'completed' ? " selected" : "") . ">Completed</option>
                            </select>";
                        echo "<button type='submit' name='update'>Update</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No orders found</td></tr>";
                }

                // Close connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
