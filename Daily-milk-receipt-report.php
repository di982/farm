<?php
// Connect to the database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "farm";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $porterName = $_POST["porter_name"];
    $farmerNames = $_POST["farmer_name"];
    $morningMilkQuantities = $_POST["morning_milk_quantity"];
    $eveningMilkQuantities \.,= $_POST["evening_milk_quantity"];
    $date = $_POST["date"];

    // Iterate over the arrays and insert data into the database
    for ($i = 0; $i < count($farmerNames); $i++) {
        $farmerName = $farmerNames[$i];
        $morningMilkQuantity = $morningMilkQuantities[$i];
        $eveningMilkQuantity = $eveningMilkQuantities[$i];
        $totalMilkQuantity = $morningMilkQuantity + $eveningMilkQuantity;

        $sql = "INSERT INTO milk_receipt (porter_name, farmer_name, morning_milk_quantity, evening_milk_quantity, total_milk_quantity, date)
                VALUES ('$porterName', '$farmerName', '$morningMilkQuantity', '$eveningMilkQuantity', '$totalMilkQuantity', '$date')";
        if ($conn->query($sql) === TRUE) {
            echo "Data inserted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Generate and display the daily milk receipt report
$date = date("Y-m-d"); // Current date
$sql = "SELECT porter_name, farmer_name, morning_milk_quantity, evening_milk_quantity, (morning_milk_quantity + evening_milk_quantity) AS total_milk_quantity
        FROM milk_receipt
        WHERE date = '$date'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display the report as an HTML table
    echo "<table>";
    echo "<tr><th>Porter Name</th><th>Farmer Name</th><th>Morning Milk Quantity</th><th>Evening Milk Quantity</th><th>Total Milk Quantity</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["porter_name"] . "</td>";
        echo "<td>" . $row["farmer_name"] . "</td>";
        echo "<td>" . $row["morning_milk_quantity"] . "</td>";
        echo "<td>" . $row["evening_milk_quantity"] . "</td>";
        echo "<td>" . $row["total_milk_quantity"] . "</td>";

        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "No milk receipt data found for today.";
}

$conn->close();
?>