<?php
session_start();
include('db/connect.php');

if(isset($_SESSION['userid'])) {
    if($_SESSION['account-type'] == "customer") {
        $order = file_get_contents('php://input'); 
        $order = json_decode($order, true); 
        $user_id = $_SESSION['userid'];
        $rest_id = $order->$details->$rest_id;
        $time_slot = $order->$details->$time;
        $no_of_seats = $order->$details->$seats;
        $items = $order->$items;
        
    }
} else {
    http_response_code(401);
}


?>