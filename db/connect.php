<?php
include('db/credentials.php');
$conn = mysqli_connect($host, $username, $password, $database);

if(!$conn) {
    echo "Error in connection";
    die();
}else {
    echo "Successfully connected to database";
}
?>