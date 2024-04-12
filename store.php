<?php
session_start();
include("ext_php/connection.php");

// Initialize session and check if user is logged in
$temp = "Guest";
$username = isset($_SESSION["Username"]) ? $_SESSION["Username"] : $temp;
if ($username === $temp) {
    header("Location: loginagain.html");
    exit();
}

// Fetch data from the inventory table
$query = "SELECT * FROM inventory";
$result = mysqli_query($conn,$query);

if (!$result) {
    die("Query failed: " . $connection->error);
}
// Logout functionality
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: logout.html");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inventory Baccabiu</title>
    <link rel="stylesheet" href="css/store.css">
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
                    <img src="img/login-removebg-preview.png" alt="Avatar" class="log">
                </div>
                <div class="info">
                    <span class="username"><?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span> 
                    <form method="post" onsubmit="return confirm('Are you sure you want to logout?');">
                        <button type="submit" name="logout" class="logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="item-list">
        <div class="itemls">
            <h2>Item List</h2>
        </div>

        <div class="resetBtn">
            <button class="reset-button" onclick="resetFilters()">Reset Filters</button>
        </div>

        <table id="itemTable" class="table-container">
        <thead>
                <tr>
                    <!-- Table headers with custom filter dropdowns -->
                    <th>
                        SN
                        <div class="filter-dropdown" data-index="0">
                            <button class="filter-button" onclick="toggleDropdown(event)">Filter</button>
                            <div class="dropdown-content">
                                <label><input type="checkbox" value="">All</label>
                            </div>
                        </div>
                    </th>
                    <th>
                        Code
                        <div class="filter-dropdown" data-index="1">
                            <button class="filter-button" onclick="toggleDropdown(event)">Filter</button>
                            <div class="dropdown-content">
                                <label><input type="checkbox" value="">All</label>
                            </div>
                        </div>
                    </th>
                    <th>
                        Category
                        <div class="filter-dropdown" data-index="2">
                            <button class="filter-button" onclick="toggleDropdown(event)">Filter</button>
                            <div class="dropdown-content">
                                <label><input type="checkbox" value="">All</label>
                            </div>
                        </div>
                    </th>
                    <th>
                        Location
                        <div class="filter-dropdown" data-index="3">
                            <button class="filter-button" onclick="toggleDropdown(event)">Filter</button>
                            <div class="dropdown-content">
                                <label><input type="checkbox" value="">All</label>
                            </div>
                        </div>
                    </th>
                    <!-- Move the "Quantity" column header here -->
                    <th>
                        Quantity
                        <div class="filter-dropdown" data-index="4">
                            <button class="filter-button" onclick="toggleDropdown(event)">Filter</button>
                            <div class="dropdown-content">
                                <label><input type="checkbox" value="">All</label>
                            </div>
                        </div>
                    </th>
                    <th>
                        NPR Rate
                        <div class="filter-dropdown" data-index="5">
                            <button class="filter-button" onclick="toggleDropdown(event)">Filter</button>
                            <div class="dropdown-content">
                                <label><input type="checkbox" value="">All</label>
                            </div>
                        </div>
                    </th>
                    <th>
                        USD Rate
                        <div class="filter-dropdown" data-index="6">
                            <button class="filter-button" onclick="toggleDropdown(event)">Filter</button>
                            <div class="dropdown-content">
                                <label><input type="checkbox" value="">All</label>
                            </div>
                        </div>
                    </th>
                    <th>
                        Total NPR
                        <div class="filter-dropdown" data-index="7">
                            <button class="filter-button" onclick="toggleDropdown(event)">Filter</button>
                            <div class="dropdown-content">
                                <label><input type="checkbox" value="">All</label>
                            </div>
                        </div>
                    </th>
                    <th>
                        Total USD
                        <div class="filter-dropdown" data-index="8">
                            <button class="filter-button" onclick="toggleDropdown(event)">Filter</button>
                            <div class="dropdown-content">
                                <label><input type="checkbox" value="">All</label>
                            </div>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the result set and display each row
                $totalQuantity = 0;
                $totalNPR = 0;
                $totalUSD = 0;

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Sn'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['code'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['quantity'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['NPRrate'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['USDrate'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['totalNPR'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['totalUSD'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "</tr>";

                    // Calculate totals
                    $totalQuantity += (int)$row['quantity'];
                    $totalNPR += (float)$row['totalNPR'];
                    $totalUSD += (float)$row['totalUSD'];
                    
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;">Total:</td>
                    <td id="totalQuantity"><?php echo $totalQuantity; ?></td>
                    <td id="totalNPRRate">-</td>
                    <td id="totalUSDRate">-</td>
                    <td id="totalNPR"><?php echo $totalNPR; ?></td>
                    <td id="totalUSD"><?php echo $totalUSD; ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <script src="js/store.js"></script>
</body>

</html>

