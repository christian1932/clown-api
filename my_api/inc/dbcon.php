<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "dbsample";
$conn = "";

try{
    $conn = mysqli_connect($servername, $username, $password, $dbname);
}
catch (mysqli_sql_exception) {
    echo"Connection failed!";
}
?>
