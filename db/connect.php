<?php
include('credentials.php');
$conn = mysqli_connect($host, $username, $password, $database);
if(!$conn) {
    echo "Error in connecting to database";
}
?>
