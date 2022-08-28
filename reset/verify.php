<?php
include("../db/connect.php");
$email = $_POST['email'];
$answer = hash('md5', strtolower($_POST['answer']));
$account_type = $_POST['account-type'];
$password = hash('md5', $_POST['newpass']);
$query = "select * from $account_type where email='$email' AND answer='$answer'";
echo $query . "<br>";
if(mysqli_num_rows(mysqli_query($conn, $query))>0) {
    $query = "update $account_type set password='$password' where email='$email'";
    echo $query . "<br>";
    if(mysqli_query($conn, $query)){
        header("Location: /orbs/login?status=resetsuccess");
    }else{
        header("Location: /orbs/login?status=resetfailed");
    }
}else{
    header("Location: /orbs/login?status=resetfailed");
}
?>