<?php
$host = "localhost";  
$username = "username";  
$password = "password";  
$database = "farm";  

// Create a connection
$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM farmers WHERE id = $farmerId"; 
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Display the farmer's information
    echo "<h2>Farmer Details</h2>";
    echo "<p><strong>Name:</strong> " . $row['name'] . "</p>";
    echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
    echo "<p><strong>Phone:</strong> " . $row['phone'] . "</p>";
    echo "<p><strong>National id:</strong> " . $row['national_id'] . "</p>";
    echo "<p><strong>Bank Name:</strong> " . $row['bank_name'] . "</p>";
    echo "<p><strong>Bank Account:</strong> " . $row['bank_account'] . "</p>";
    echo "<p><strong>Porter Name:</strong> " . $row['porter_name'] . "</p>";
    echo "<p><strong>Porter National Id:</strong> " . $row['porter_national_id'] . "</p>";

} else {
    echo "No farmer found with the specified ID.";
}

mysqli_close($connection);
?>
