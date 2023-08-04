<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: home.html');
	exit;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Farmers Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Farmer Details</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>
            <table class="table">
  <thead>
  </thead>
  <tbody>
    <tr>
      <td><?php echo$name?></td>
</tr>
  <tr>
    <td><?php echo$national_id?></td>
</tr>    
      <tr>
        <td><?php echo$Phone_no?></td>
    </tr>
      <tr>
        <td><?php echo$location?></td>
    </tr>
      <tr>
        <td><?php echo$Porter_Name?></td>
    </tr>
      <tr>
        <td><?php echo$Bank_name?></td>
    </tr>
      <tr>
        <td><?php echo$Bank_account?></td>
    </tr>
      <tr>
        <td><?php echo$Branch?></td>
    </tr>
    </tr>
  </tbody>
</table>
		</div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
	</body>
</html>