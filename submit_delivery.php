<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $farmerId = $_POST['farmer_id'];
    $milkQuantityMorning = $_POST['milk_quantity_morning'];
    $milkQuantityEvening = $_POST['milk_quantity_evening'];
    $deliveryDate = $_POST['delivery_date'];

    // Perform validation
    $errors = [];

    // Validate farmer ID
    if (empty($farmerId)) {
        $errors[] = "Farmer's ID is required.";
    }

    // Validate milk quantity (morning)
    if (empty($milkQuantityMorning)) {
        $errors[] = "Milk quantity (morning) is required.";
    } elseif (!is_numeric($milkQuantityMorning) || $milkQuantityMorning < 0) {
        $errors[] = "Milk quantity (morning) must be a positive numeric value.";
    }

    // Validate milk quantity (evening)
    if (empty($milkQuantityEvening)) {
        $errors[] = "Milk quantity (evening) is required.";
    } elseif (!is_numeric($milkQuantityEvening) || $milkQuantityEvening < 0) {
        $errors[] = "Milk quantity (evening) must be a positive numeric value.";
    }

    // Validate delivery date
    if (empty($deliveryDate)) {
        $errors[] = "Delivery date is required.";
    } else {
        // Perform additional validation or checks on the delivery date if needed
        // For example, check if the delivery date is in the desired range, format, etc.
    }

    // If there are validation errors, display error messages and allow the user to correct the form
    if (!empty($errors)) {
        echo "<h2>Error(s) occurred:</h2>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "<p><a href=\"delivery_form.php\">Go back to the delivery form</a></p>";
    } else {
        // If the form inputs pass validation, proceed with storing the delivery details in the database

        // Establish a connection to your MySQL database
        $hostname = 'localhost';
        $username = 'username';
        $password = 'password';
        $database = 'farm';

        $conn = new mysqli($hostname, $username, $password, $database);
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        // Prepare the SQL statement to insert the delivery details into the database
        $sql = "INSERT INTO deliveries (farmer_id, milk_quantity_morning, milk_quantity_evening, delivery_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiis", $farmerId, $milkQuantityMorning, $milkQuantityEvening, $deliveryDate);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "<h2>Delivery details recorded successfully!</h2>";
        } else {
            echo "<h2>Error occurred while storing the delivery details.</h2>";
        }

        $stmt->close();
        $conn->close();

    }
} else {
    // If the form is not submitted, redirect the user to the delivery form
    header("Location: delivery_form.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Form</title>
    <style>
        /* CSS styles for the form */
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delivery Form</h2>
        <form action="submit_delivery.php" method="post">
            <div class="form-group">
                <label for="farmer_id">Farmer's ID</label>
                <select name="farmer_id" id="farmer_id" required>
                    <option value="">Select Farmer's ID</option>
                    <!-- Populate the dropdown options dynamically from the database -->
                    <?php
                    // Fetch farmer IDs from the database and populate the options
                    $hostname = 'your_hostname';
                    $username = 'your_username';
                    $password = 'your_password';
                    $database = 'your_database';

                    $conn = new mysqli($hostname, $username, $password, $database);
                    if ($conn->connect_error) {
                        die('Connection failed: ' . $conn->connect_error);
                    }

                    $sql = "SELECT farmer_id FROM farmers";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['farmer_id'] . '">' . $row['farmer_id'] . '</option>';
                        }
                    }

                    $conn->close();
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="milk_quantity_morning">Milk Quantity (Morning)</label>
                <input type="number" name="milk_quantity_morning" id="milk_quantity_morning" placeholder="Enter morning milk quantity" required>
            </div>

            <div class="form-group">
                <label for="milk_quantity_evening">Milk Quantity (Evening)</label>
                <input type="number" name="milk_quantity_evening" id="milk_quantity_evening" placeholder="Enter evening milk quantity" required>
            </div>

            <div class="form-group">
                <label for="delivery_date">Day of Delivery</label>
                <input type="date" name="delivery_date" id="delivery_date" required>
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>

