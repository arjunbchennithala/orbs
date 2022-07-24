<?php
session_start();
unset($_SESSION['userid']);
unset($_SESSION['account-type']);
header("Location: /orbs");
?>