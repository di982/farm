<?php
session_start();
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "farm";
// Try and connect using the info above.
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ( !isset($_POST['username'], $_POST['password']) ) {
	exit('Please fill both the username and password fields!');
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

	$stmt->close();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            echo 'Welcome ' . $_SESSION['name'] . '!';
        } else {
            // Incorrect password
            echo 'Incorrect username and/or password!';
        }
    } else {
        // Incorrect username
        echo 'Incorrect username and/or password!';
    }
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <style>
            * {
                box-sizing: border-box;
  	            font-family: -apple-system, BlinkMacSystemFont, "segoe ui", roboto, oxygen, ubuntu, cantarell, "fira sans", "droid sans", "helvetica neue", Arial, sans-serif;
  	            font-size: 16px;
            }
            body {
                background-color: #435165;
            }
            .login {
                width: 400px;
                background-color: #ffffff;
                box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3);
                margin: 100px auto;
            }
            .login h1 {
                text-align: center;
                color: #5b6574;
                font-size: 24px;
                padding: 20px 0 20px 0;
                border-bottom: 1px solid #dee0e4;
            }
            .login form {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                padding-top: 20px;
            }
            .login form label {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 50px;
                height: 50px;
                background-color: #3274d6;
                color: #ffffff;
            }
            .login form input[type="password"], .login form input[type="text"] {
                width: 310px;
                height: 50px;
                border: 1px solid #dee0e4;
                margin-bottom: 20px;
                padding: 0 15px;
            }
            .login form input[type="submit"] {
                width: 100%;
                padding: 15px;
                margin-top: 20px;
                background-color: #3274d6;
                border: 0;
                cursor: pointer;
                font-weight: bold;
                color: #ffffff;
                transition: background-color 0.2s;
            }
            .login form input[type="submit"]:hover {
                background-color: #2868c7;
                transition: background-color 0.2s;
            }
        </style>
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form action="login.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
                If don't have an account register as<a href="register_porter.php">Porter</a> or <a href="register_farmer">Farmer</a>
			</form>
		</div>
	</body>
</html>