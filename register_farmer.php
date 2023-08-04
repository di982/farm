<?php
$host = "localhost";  // Replace with your host
$username = "username";  // Replace with your username
$password = "password";  // Replace with your password
$database = "farm";  // Replace with your database name

// Create a connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$nationalId = $_POST['national_id'];
$bankName = $_POST['bank_name'];
$bankAccount = $_POST['bank_account'];
$porterName = $_POST['porter_name'];
$porterNationalId = $_POST['porter_national_id'];

// Prepare and execute the database query
$query = "INSERT INTO farmers (name, email, phone, national_id, bank_name, bank_account, porter_name, porter_national_id) 
          VALUES ('$name', '$email', '$phone', '$nationalId', '$bankName', '$bankAccount', '$porterName', '$porterNationalId')";

if (mysqli_query($connection, $query)) {
    header("Location: farmer_details.php");
        exit();
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Registration</title>
    <style>
    * {
        font-family: sans-serif;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
    }

    form {
        margin: 0 auto;
        width: 500px;
        padding: 20px;
        border: 1px solid #ccc;
    }

    label {
        width: 100px;
        float: left;
        margin-top: 10px;
    }

    input {
        width: 300px;
        margin-left: 120px;
        margin-top: 10px;
    }

    button {
        float: right;
        margin-top: 20px;
    }
    </style>
</head>
<body>
    <h2>Farmer Registration Form</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required><br>

        <label for="national_id">National ID:</label>
        <input type="text" id="national_id" name="national_id" required><br>

        <label for="bank_name">Bank Name:</label>
        <input type="text" id="bank_name" name="bank_name" required><br>

        <label for="bank_account">Bank Account:</label>
        <input type="text" id="bank_account" name="bank_account" required><br>

        <h3>Porter Details:</h3>
        <label for="porter_name">Porter's Name:</label>
        <input type="text" id="porter_name" name="porter_name" required><br>

        <label for="porter_national_id">Porter's National ID:</label>
        <input type="text" id="porter_national_id" name="porter_national_id" required><br>

        <button type="submit" id="registerBtn">Register</button>
    </form>

    <script>
            document.getElementById("registerBtn").addEventListener("click", function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Perform any necessary client-side validation here

                // Submit the form programmatically
                document.querySelector("form").submit();
            });
    </script>
</body>
</html>