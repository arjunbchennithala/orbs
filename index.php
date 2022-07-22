<?php
session_start();
include('lib/header.php');
if(isset($_SESSION['userid'])) {
    if($_SESSION['account-type'] == 'restaurant')
        include('views/restaurant.php');
    else if($_SESSION['account-type'] == 'customer')
        include('views/customer.php');
}else{
    include('views/welcome.php');
}
include('lib/footer.php');
?>
