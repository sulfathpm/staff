<?php
// Database connection
$dbcon = mysqli_connect("localhost", "root", "", "fashion");
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start session to check if staff is logged in
session_start();
if (!isset($_SESSION['staff_id'])) {
    echo "You must log in to view this page.";
    exit();
}

$staff_id = $_SESSION['staff_id'];

// Fetch orders assigned to the staff and their corresponding user measurements
$sql = "SELECT o.ORDER_ID, o.TOTAL_PRICE, o.STATUSES, u.USERNAME, u.EMAIL, 
        m.SHOULDER, m.BUST, m.WAIST, m.HIP, m.CREATED_AT AS measurement_date
        FROM orders o
        JOIN users u ON o.USER_ID = u.USER_ID
        LEFT JOIN measurements m ON o.ORDER_ID = m.ORDER_ID
        WHERE o.STAFF_ID = ?";

$stmt = mysqli_prepare($dbcon, $sql);
mysqli_stmt_bind_param($stmt, 'i', $staff_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Orders Assigned to You</h2>";
    echo "<table border='1'>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Shoulder (cm)</th>
                <th>Bust (cm)</th>
                <th>Waist (cm)</th>
                <th>Hip (cm)</th>
                <th>Measurement Date</th>
            </tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['ORDER_ID'] . "</td>
                <td>" . $row['USERNAME'] . "</td>
                <td>" . $row['EMAIL'] . "</td>
                <td>" . $row['TOTAL_PRICE'] . "</td>
                <td>" . $row['STATUSES'] . "</td>
                <td>" . $row['SHOULDER'] . "</td>
                <td>" . $row['BUST'] . "</td>
                <td>" . $row['WAIST'] . "</td>
                <td>" . $row['HIP'] . "</td>
                <td>" . $row['measurement_date'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No orders assigned to you.";
}

mysqli_close($dbcon);
?>