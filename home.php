<?php
session_start(); // Initialize session

include("ext_php/connection.php");

$temp = "Guest";
$username = isset($_SESSION["Username"]) ? $_SESSION["Username"] : $temp; // Default to "Guest" if username is not set
if($username === $temp){
    header("Location: loginagain.html");
    exit();
}


// Logout functionality
if (isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: logout.html");
    exit(); // Ensure script execution stops after redirection
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <header class="merged-navbar">
        <div class="container">
            <div class="brand">
                <h1>Inventory Baccabiu</h1>
            </div>
            <nav class="nav-links">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="store.php">Store</a></li>
                    <li><a href="StockIn.php">Stock In</a></li>
                    <li><a href="Stockout.php">Stock Out</a></li>
                    <li><a href="history.php">History</a></li>
                </ul>
            </nav>
            <div class="user">
                <div class="avatar">
                    <img src="img/login-removebg-preview.png" alt="error" class="log">
                </div>
                <div class="info">
                    <span class="username"><?php echo $username; ?></span> <!-- Display the username -->
                    <form method="post" onsubmit="return confirm('Are you sure you want to logout?');">
                        <button type="submit" name="logout" class="logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>




    </ul>
    <div class="box-container">
        <a href="StockIn.php">
            <div class="box">
                <img src="img/S_in.svg" alt="Add Items">
                <h3>Add Items</h3>
            </div>
        </a>
        <a href="Stockout.php">
            <div class="box">
                <img src="img/out.svg" alt="Remove Items">
                <h3>Remove Items</h3>
            </div>
        </a>
        <a href="store.php">
            <div class="box">
                <img src="img/in.svg" alt="Check items">
                <h3>Check Items</h3>
            </div>
        </a>
        <a href="history.php">
            <div class="box">
                <img src="img/history.svg" alt="History">
                <h3>History</h3>
            </div>
        </a>
    </div>
</body>

</html>