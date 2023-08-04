<?php

$conn = new mysqli('localhost', 'username', 'password', 'farm');

// Retrieve the form data
$name = $_POST['name'];
$phone = $_POST['phone'];
$bankName = $_POST['bank_name'];
$bankAccount = $_POST['bank_account'];
$farmerNames = $_POST['farmer_name'];
$farmerPhones = $_POST['farmer_phone'];

// Perform validation checks
$errors = [];
if (empty($name)) {
    $errors[] = "Name is required.";
}
if (empty($phone)) {
    $errors[] = "Phone is required.";
}
if (empty($bankName)) {
    $errors[] = "Bank Name is required.";
}
if (empty($bankAccount)) {
    $errors[] = "Bank Account is required.";
}
if (empty($farmerNames) || empty($farmerPhones)) {
    $errors[] = "Please add at least one farmer.";
}

// If there are validation errors, display error messages
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
} else {
    // Store the porter and farmer details in the database
    // Set up a database connection and insert the data using SQL INSERT statements
    // Adjust the code below according to your database structure

    // Establish database connection
    $conn = new mysqli('localhost', 'username', 'password', 'farm');

    // Check if connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert porter data into the porter table
    $insertPorterSql = "INSERT INTO porter (name, phone, bank_name, bank_account)
                        VALUES (?, ?, ?, ?)";
    $stmtPorter = $conn->prepare($insertPorterSql);
    $stmtPorter->bind_param("ssss", $name, $phone, $bankName, $bankAccount);
    $stmtPorter->execute();

    // Get the auto-generated porter ID
    $porterId = $stmtPorter->insert_id;

    // Insert farmer data into the farmers table and create the relationship in farmer_porter table
    $insertFarmerSql = "INSERT INTO farmers (name, phone) VALUES (?, ?)";
    $insertRelationSql = "INSERT INTO farmer_porter (farmer_id, porter_id) VALUES (?, ?)";

    $stmtFarmer = $conn->prepare($insertFarmerSql);
    $stmtRelation = $conn->prepare($insertRelationSql);

    // Loop through the submitted farmer data and insert them into the database
    for ($i = 0; $i < count($farmerNames); $i++) {
        $farmerName = $farmerNames[$i];
        $farmerPhone = $farmerPhones[$i];

        $stmtFarmer->bind_param("ss", $farmerName, $farmerPhone);
        $stmtFarmer->execute();

        // Get the auto-generated farmer ID
        $farmerId = $stmtFarmer->insert_id;

        // Create the relationship between the farmer and porter
        $stmtRelation->bind_param("ii", $farmerId, $porterId);
        $stmtRelation->execute();
    }

    // Check if the data was inserted successfully
    if ($stmtPorter->affected_rows > 0 && $stmtFarmer->affected_rows > 0 && $stmtRelation->affected_rows > 0) {
        echo "Registration successful.";
    } else {
       echo "Registration failed.";
    }

    // Close the statements and database connection
    $stmtPorter->close();
    $stmtFarmer->close();
    $stmtRelation->close();
    $conn->close();
}
?>
