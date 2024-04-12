<?php
$host = "localhost";
$port = "3306";
$userrr = "root";
$password = "";
$database = "invbaccabu";

$conn = mysqli_connect($host.":".$port, $userrr, $password, $database);

if (!$conn) {
    echo "Not connected";
    die();
}