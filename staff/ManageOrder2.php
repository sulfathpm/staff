<?php
// Database connection settings
$host = "localhost";  // Your database host
$dbname = "fashion";  // Your database name
$username = "root";  // Your database username
$password = "";  // Your database password

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted for updating the status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // SQL query to update the order status
    $sql = "UPDATE orders SET STATUSES = ? WHERE ORDER_ID = ?";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);  // "si" means string (status) and integer (order_id)

    // Execute the update query
    if ($stmt->execute()) {
        echo "<p>Order status updated successfully!</p>";
    } else {
        echo "<p>Error updating record: " . $conn->error . "</p>";
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="staff.css">
    <style>
        .status-display {
            display: block;
        }
        .status-update {
            display: none;
        }
    </style>
    <script>
        function showUpdateForm(orderId) {
            // Hide the text display and show the dropdown for the specific order
            document.getElementById('status-display-' + orderId).style.display = 'none';
            document.getElementById('status-update-' + orderId).style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="header">
        <h1>Manage Orders</h1>
    </div>

    <div class="staff-dashboard">
        <!-- Sidebar for navigation -->
        <aside class="sidebar">
            <h3>Menu</h3>
            <a href="manageOrder.php">Manage Orders</a>
            <a href="measurement.php">Measurements</a>
        </aside>

        <!-- Main content area -->
        <main class="main-content">
            <section id="manage-orders-section" class="card">
                <h2>Manage Orders</h2>
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
                        // SQL query to fetch orders from the database
                        $sql = "SELECT orders.ORDER_ID, users.USER_ID, orders.SSIZE, orders.STATUSES, orders.ESTIMATED_DELIVERY_DATE 
                                FROM orders
                                INNER JOIN users ON orders.USER_ID = users.USER_ID";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Loop through the data and display each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['ORDER_ID'] . "</td>";
                                echo "<td>" . $row['USER_ID'] . "</td>";
                                echo "<td>" . $row['SSIZE'] . "</td>";

                                // Display the current status as plain text
                                echo "<td>";
                                echo "<span id='status-display-" . $row['ORDER_ID'] . "' class='status-display'>" . ucfirst($row['STATUSES']) . "</span>";

                                // Add a hidden form for updating only the status, with a dropdown that appears on clicking 'Update'
                                echo "<form action='' method='post' id='status-update-" . $row['ORDER_ID'] . "' class='status-update'>";
                                echo "<input type='hidden' name='order_id' value='" . $row['ORDER_ID'] . "'>";
                                echo "<select name='status'>
                                        <option value='pending'" . ($row['STATUSES'] == 'pending' ? " selected" : "") . ">Pending</option>
                                        <option value='in progress'" . ($row['STATUSES'] == 'in progress' ? " selected" : "") . ">In Progress</option>
                                        <option value='completed'" . ($row['STATUSES'] == 'completed' ? " selected" : "") . ">Completed</option>
                                        <option value='delivered'" . ($row['STATUSES'] == 'delivered' ? " selected" : "") . ">Delivered</option>
                                        <option value='cancelled'" . ($row['STATUSES'] == 'cancelled' ? " selected" : "") . ">Cancelled</option>
                                    </select>";
                                echo "</td>";

                                echo "<td>" . $row['ESTIMATED_DELIVERY_DATE'] . "</td>";

                                // Add a button to trigger the form and change the display to show the dropdown
                                echo "<td><button type='button' onclick='showUpdateForm(" . $row['ORDER_ID'] . ")'>Update</button></td>";
                                echo "<td><button type='submit' name='update'>Save</button></form></td>";

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
            </section>
        </main>
    </div>
</body>
</html>
