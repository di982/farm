<?php
$hostname = 'localhost';
$username = 'username';
$password = 'password';
$database = 'farm';

$conn = new mysqli($hostname, $username, $password, $database);
// Assuming you have already established a database connection

// Retrieve the total number of farmers
$query = "SELECT COUNT(*) AS totalFarmers FROM farmers";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$totalFarmers = $row['totalFarmers'];

// Retrieve the total number of porters
$query = "SELECT COUNT(*) AS totalPorters FROM porters";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$totalPorters = $row['totalPorters'];

// Retrieve the total number of deliveries
$query = "SELECT COUNT(*) AS totalDeliveries FROM deliveries";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$totalDeliveries = $row['totalDeliveries'];

// Retrieve the total number of payments
$query = "SELECT COUNT(*) AS totalPayments FROM payments";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$totalPayments = $row['totalPayments'];

// Close the database connection
mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <!-- Add your custom CSS styles -->
    <style>
        /* Custom CSS styles for the dashboard overview */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;0,800;1,600&display=swap');

        :root{
            --color-primary:#7380ec;
            --color-danger:red;
            --color-success:#41f1b6;
            --color-warning:#ffbb55;
            --color-white:#fff;
            --color-info-dark:#7d8da1;
            --color-info-white:#dce1eb;
            --color-dark:#363949;
            --color-light:rgba(132,139,200,0.18);
            --color-primary-variant:#111e88;
            --color-dark-variant:#677483;
            --color-background:#f6f6f9;

            --color-border-radius:2rem;
            --border-radius-1:0.4rem;
            --border-radius-2:0.8rem;
            --border-radius-3:1.2rem;

            --card-padding:1.8rem;
            --padding-1:1.2rem;

            --box-shadow:0 2rem 3rem var(--color-light)
        }

        /* =================Dark Theme Variables================= */
        .dark-theme-variables{
        --color-background:#181a1e;
        --color-white:#202528;
        --color-dark:#a3bdcc;
        --color-dark-dark-variant:#a3bdcc;
        --color-light:rgba(0,0,0.4);
        --box-shadow:0 2rem 3rem var(--color-light);
        }



        *{
            margin: 0;
            padding: 0;
            outline: 0;
            appearance: none;
            border: 0;
            text-decoration: none;
            list-style: none;
            box-sizing: border-box;
        }
        html{
            font-size: 14px;
        }
        body{
            width: 100vw;
            height: 100vh;
            font-family: poppins,sans-serif;
            font-size: 0.88rem;
            background: var(--color-background);
            user-select:none;
            overflow-x:hidden;
        }

        .container{
            display: grid;
            width: 96%;
            margin: 0 auto;
            gap: 1.8rem;
            grid-template-columns: 14rem auto 23rem;
        }
        a{
            color: var(--color-dark);
        }
        img{
            display: block;
            width: 100%;
        }
        h1{
            font-weight: 800;
            font-size: 1.8rem;  
        }
        h2{
            font-size: 1.4rem;
        }
        h3{
            font-size: 0.87rem;
        }
        h4{
            font-size: 0.8rem;
        }
        h5{
            font-size: 0.77rem;
        }
        small{
            font-size: 0.75rem;
        }
        .profile-photo{
            width:2.8rem;
            height:2.8rem;
            border-radius: 50%;
            overflow: hidden;
        }
        .text-muted{
            color: var(--color-info-dark);
        }
        p{
            color: var(--color-dark-variant);
        }
        b{
            color: var(--color-dark);
        }
        .primary{
            color:var(--color-primary) ;
        }
        .danger{
            color:var(--color-danger) ;
        }
        .success{
            color: var(--color-success);
        }
        .warning{
            color: var(--color-warning);
        }


        aside{
            height: 100vh;
        }
        
        aside .top{
            background: white;
            display: flex;
            align-items: centers;
            justify-content: space-between;
            margin-top: 1.5rem;
        }
        aside .logo{
            display: flex;
        }
        aside .logo img{
            width:2rem;
            height:2rem;
        }
        aside .close{
            display: none;
        }
        aside .sidebar{
            display: flex;
            flex-direction: column;
            height:86vh;
            position: relative;
            top: 3rem;
        }
        aside .h3{
            font-weight:500;
            
        }
        aside .sidebar a{
            display: flex;
            color: var(--color-info-dark);
            margin-left:2rem;
            gap:1rem;
            align-items: center;
            position: relative;
            height: 3.7rem;
            transition: all 300ms ease;
        }
        aside .sidebar a span{
            font-size: 1.6rem;
            transition: all 400ms ease;
        }
        aside.sidebar a:last-child{
            position: relative;
            bottom: 2rem;
            width: 100%;
        }
        aside .sidebar a.active{
            background: var(--color-light);
            color: var(--color-primary);
            margin-left: 0;
        }
        aside .sidebar a.active:before{
            content: "";
            width: 6px;
            height: 100%;
            background: var(--color-primary);
        }
        aside .sidebar a.active span{
            color: var(--color-primary);
            margin-left: calc(1rem - 3px);
        }
        aside .sidebar a.hover{
            color: var(--color-primary);
        }
        aside .sidebar a.hover span{
            margin-left: 2rem;
        }
        aside .sidebar .mail-count{
            background: var(--color-danger);
            color: var(--color-white);
            padding: 2px 10px;
            font-size:11px;
            border-radius: var(--border-radius-1);
        }
        aside .sidebar .notifications-count{
            background: var(--color-danger);
            color: var(--color-white);
            padding: 2px 10px;
            font-size:11px;
            border-radius: var(--border-radius-1);
        }
        </style>
</head>
<body>
    <!-- Assuming you have a basic HTML template with necessary CSS and JavaScript files included -->
    <div class="container">
    <aside>
      <div class="top">
        <div class="logo">
          <img src="logo.png">
          <h2>Dairy Farm<span class="danger">System</span></h2>
        </div>
        <div class="close" id="close-btn">
          <span class="material-icons-sharp">close</span>
        </div>
      </div>
      <div class="sidebar">
        <a href="#dashboard">
          <span class="material-icons-sharp">grid_view</span>
          <h3>Dashboard</h3>
        </a>
        <a href="farmer.php" class="active">
          <span class="material-icons-sharp">people</span>
          <h3>Farmer Managemnt</h3>
        </a>
        <a href="porter_management.html">
          <span class="material-icons-sharp">people</span>
          <h3>Porter Mangement</h3>
        </a>
        <a href="delivery_management.php">
          <span class="material-icons-sharp">local_shipping</span>
            <h3>Delivery Management</h3>
        </a>
        <a href="report.php">
          <span class="material-icons-sharp">summarize</span>
            <h3>Reports</h3>
            <span class="notifications-count">2</span>
        </a>
        <a href="payment.php">
          <span class="material-icons-sharp">assessment</span>
          <h3>Payment</h3>
          <span class="mail-count">26</span>
        </a>
        <a href="settings.php">
            <span class="material-icons-sharp">settings</span>
            <h3>settings</h3>
          </a>
          <a href="logout.php">
            <span class="material-icons-sharp">logout</span>
            <h3>log-out</h3>
          </a>
        </a>
      </div>
    </aside>
        <div class="metrics">
            <div class="metric">
                <h3>Total Farmers</h3>
                <p>
                    <?php echo $totalFarmers;
                     ?>
                    </p>
            </div>
            <div class="metric">
                <h3>Total Porters</h3>
                <p>
                    <?php echo $totalPorters; ?>
                </p>
            </div>
            <div class="metric">
                <h3>Total Deliveries</h3>
                <p><?php echo $totalDeliveries; ?></p>
            </div>
            <div class="metric">
                <h3>Total Payments</h3>
                <p><?php echo $totalPayments; ?></p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Assuming you have the necessary data to generate a chart
            var ctx = document.getElementById('dashboardChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Farmers', 'Porters', 'Deliveries', 'Payments'],
                    datasets: [{ label: 'Metrics',
                        data: [
                            <?php echo $totalFarmers; ?>, 
                            <?php echo $totalPorters; ?>,
                            <?php echo $totalDeliveries; ?>,
                            <?php echo $totalPayments; ?>
                        ],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
     </script>
</body>
</html>