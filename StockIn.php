<?php
include("ext_php/connection.php");
session_start(); // Initialize session

// Check if username is set in session
$temp = "Guest";
$username = isset($_SESSION["Username"]) ? $_SESSION["Username"] : $temp; // Default to "Guest" if username is not set
if($username === $temp){
    header("Location: loginagain.html");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $code1 = $_POST["code"];
    $user1 = $username;
    $date1 = $_POST["date"];
    $category1 = $_POST["category"];
    $location1 = $_POST["location"];
    $reason1 = $_POST["reason"];
    $quantity1 = (int)$_POST["quantity"]; // Cast quantity to integer
    $NPRrate1 = (float)$_POST["NPRrate"]; // Cast NPR rate to float
    $USDrate1 = (float)$_POST["USDrate"]; // Cast USD rate to float

    // Calculate the total amounts in NPR and USD
    $totalNPR1 = $quantity1 * $NPRrate1;
    $totalUSD1 = $quantity1 * $USDrate1;

    // Prepare the SQL query to insert data into the 'history' table
    $qry1 = "INSERT INTO history (code, user,  date, category, location, reason, quantity, totalNPR, totalUSD)
            VALUES ('$code1', '$user1', '$date1', '$category1', '$location1', '$reason1', $quantity1, $totalNPR1, $totalUSD1)";

    // Execute the query
    $res1 = mysqli_query($conn, $qry1);

    // Handle the result
    if (!$res) {
        // Display error if the query fails
        echo "Error: " . mysqli_error($conn);
    } else {
        // Success message
        echo "";
    }
    
    // Retrieve form data
    $code = $_POST["code"];
    $category = $_POST["category"];
    $location = $_POST["location"];
    $quantity = (int)$_POST["quantity"]; // Cast quantity to integer
    $rate_npr = (float)$_POST["NPRrate"]; // Cast rates to float
    $rate_usd = (float)$_POST["USDrate"]; // Cast rates to float

    // Query to check if the combination of code and location already exists
    $checkQuery = "SELECT * FROM inventory WHERE code = '$code' AND location = '$location'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // If the combination exists, update the existing row
        $updateQuery = "UPDATE inventory
                        SET quantity = quantity + $quantity,
                            NPRrate = $rate_npr,
                            USDrate = $rate_usd
                        WHERE code = '$code' AND location = '$location'";
        $res = mysqli_query($conn, $updateQuery);

        if (!$res) {
            echo "<script>alert('Failed to update the item. Please try again.');</script>";
        } else {
            echo "<script>alert('Item updated successfully.');</script>";
        }
    } else {
        // If the combination does not exist, insert a new row
        $insertQuery = "INSERT INTO inventory (code, category, location, quantity, NPRrate, USDrate)
                        VALUES ('$code', '$category', '$location', $quantity, $rate_npr, $rate_usd)";
        $res = mysqli_query($conn, $insertQuery);

        if (!$res) {
            echo "<script>alert('Failed to add a new item. Please try again.');</script>";
        } else {
            echo "<script>alert('New item added successfully.');</script>";
        }
    }

    // Use `exit()` to prevent further script execution
    echo "<script>window.location.href = 'StockIn.php';</script>";
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
    <link rel="stylesheet" href="css/StockIn.css">
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
    
    
    <div class="item-add">
        <h2>Add Item</h2>
        <form id="itemForm" method="POST" action="StockIn.php">
            <label for="code">Code: (Make sure to recheck it )</label>
            <input type="text" id="code" name="code" required>
            
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            
            <label for="category">Category: (Make sure to recheck it )</label>
            <select id="category" name="category" required>
                <option value="hat">Hemp Hat</option>
                <option value="socks">Socks</option>
            </select>
            
            <label for="location">Location: (Make sure to recheck it )</label>
            <select id="location" name="location" required>
                <option value="location1">Location 1</option>
                <option value="location2">Location 2</option>
            </select>

            <label for="reason">Description:</label>
            <input type="text" id="reason" name="reason" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity"min="0" required>
            
            <label for="NPRrate">per pic Rate (NPR):</label>
            <input type="number" id="NPRrate" name="NPRrate" min="0" required>
            
            <label for="USDrate">per pic Rate (USD):</label>
            <input type="text" id="USDrate" name="USDrate"min="0" required>
            <div class="display"> 
                <h4 id="totalNPR"></h4>
                <h4 id="totalUSD"></h4>
            </div>
            <div class="btn">
                <button type="submit" >Insert Item</button>
                
                <button type="reset">Reset</button>
            </div>
        </form>
    </div>

    <script src="js/StockIn.js"></script>
    </body>
</html>
