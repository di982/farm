<?php
// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve selected month and year from the form
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Fetch data from the database based on the selected month and year
    $query = "SELECT f.farmer_id, f.farmer_name, SUM(d.milk_quantity_morning + d.milk_quantity_evening) AS total_milk_quantity
              FROM farmers f
              INNER JOIN deliveries d ON f.farmer_id = d.farmer_id
              WHERE MONTH(d.delivery_date) = ? AND YEAR(d.delivery_date) = ?
              GROUP BY f.farmer_id, f.farmer_name";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $month, $year);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Calculate metrics or perform other necessary calculations
    // ...

    // Generate the report dynamically
    $report = '<h2>Monthly Delivery Report</h2>';
    $report .= '<table>';
    $report .= '<thead><tr><th>Farmer ID</th><th>Farmer Name</th><th>Total Milk Quantity</th></tr></thead>';
    $report .= '<tbody>';
    foreach ($data as $row) {
        $report .= '<tr>';
        $report .= '<td>' . $row['farmer_id'] . '</td>';
        $report .= '<td>' . $row['farmer_name'] . '</td>';
        $report .= '<td>' . $row['total_milk_quantity'] . '</td>';
        $report .= '</tr>';
    }
    $report .= '</tbody>';
    $report .= '</table>';

    // Display the report to the user
    echo $report;
}
?>

<!-- HTML form for selecting the month and year -->
<form method="post" action="report.php">
    <label for="month">Month:</label>
    <input type="number" id="month" name="month" min="1" max="12" required>
    <label for="year">Year:</label>
    <input type="number" id="year" name="year" min="2000" max="2099" required>
    <button type="submit">Generate Report</button>
</form>
