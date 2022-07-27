<?php
session_start();
//include('db/connect.php');
$msg = "First line of msg\nSecond line";
$msg = wordwrap($msg, 70);

$res = mail("arjunbchennithala@gmail.com", "My Subject", $msg);
if($res) {
    echo "Success\n";
}else{
    echo "Failure\n";
}
?>