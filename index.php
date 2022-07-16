<?php
include('session/session.php');
include('lib/header.php');
if(isset($_COOKIE['SESSID']))
    $sessid = $_COOKIE['SESSID'];
else
    $sessid = 0;

if(isValid($sessid)) {
    $details = getDetails($sessid);
    if($details['utype'] == 'restaurant')
        include('views/restaurant.php');
    else if($details['utype'] == 'customer')
        include('views/customer.php');
}else{
    include('views/welcome.php');
}
include('lib/footer.php');
?>