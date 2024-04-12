<?php
include("ext_php/connection.php");


session_start();

$emailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email)) {
        $emailErr = "Email is required!";
    }

    if (empty($password)) {
        $passwordErr = "Password is required!";
    }

    if (!empty($email) && !empty($password)) {
        // Validate user input and execute SQL query
        $sql = "SELECT * FROM UserData WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION["Username"] = $row["Username"]; // Set session variable with username
            header("Location: home.php"); // Redirect to home page
            exit(); // Ensure script execution stops after redirection
        } else {
            $passwordErr = "Email or password is incorrect!";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login - BACCABIU</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to Baccabiu</h1>
        <form action="login.php" method="POST">
            <div class="input-group">
                <span class="error"><p><?php echo $passwordErr;?></p></span>
                <span class="error"><p><?php echo $emailErr;?></p></span>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <button type="submit" id="loginBtn">Login</button>
        </form>
    </div>
</body>
</html>



