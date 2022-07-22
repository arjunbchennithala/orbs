<?php
include('session/session.php');
include('lib/header.php');
if(isset($_SESSION['userid'])) {
    if($_SESSION['account-type'] == 'restaurant')
?>