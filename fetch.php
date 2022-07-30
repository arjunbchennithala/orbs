<?php
session_start();
include('db/connect.php');
header("Content-Type: application/json");
if(isset($_SESSION['userid'])) {
    $type = $_GET['type'];
    $skip = mysqli_real_escape_string($conn, $_GET['skip']);
    if(isset($_GET['id'])) 
        $id = mysqli_real_escape_string($conn, $_GET['id']);
    else
        $id = '';

    if($type == 'restaurants') {
        if($id == '') 
            $query = "select id, name, address, location_link, email, phon_no, created, rating from restaurant order by id desc limit $skip, 50";
        else
            $query = "select id, name, address, location_link, email, phon_no, created, rating from restaurant order by id desc where id=$id";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {   
            $restaurant = mysqli_fetch_all($res);
            echo json_encode($restaurant);
        }else{
            http_response_code(204);
        }
    }else if($type == 'customers') {
        if($id == '') 
            $query = "select id, name, dob, email, mobile_number, state, profile_photo from customer order by id desc limit $skip, 50";
        else
            $query = "select id, name, dob, email, mobile_number, state, profile_photo from customer order by id desc where id=$id";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {   
            $customer = mysqli_fetch_all($res);
            echo json_encode($customer);
        }else{
            http_response_code(204);
        }
    }else if($type == 'orders') {
        if($id == '') 
            $query = "select id, cust_id, rest_id, date_and_time, total_price, ordered_on, seats, state from orders limit $skip, 50";
        else
            $query = "select id, cust_id, rest_id, date_and_time, total_price, ordered_on, seats, state from orders where id=$id";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {   
            $orders = mysqli_fetch_all($res);
            echo json_encode($orders);
        }else{
            http_response_code(204);
        }
    }else if($type == 'complaints') {
        $query = "select id, rest_id, cust_id, text, date_and_time from complaints order by id desc limit $skip, 50";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {
            $complaint = mysqli_fetch_all($res);
            echo json_encode($complaint);
        }else{
            http_response_code(204);
        }
    }else if($type == 'counts') {
        $query = "select count(id) from restaurant";
        $res = mysqli_query($conn, $query);
        $restaurant = mysqli_fetch_all($res)[0];

        $query = "select count(id) from customer";
        $res = mysqli_query($conn, $query);
        $customer = mysqli_fetch_all($res)[0];

        $query = "select count(id) from orders";
        $res = mysqli_query($conn, $query);
        $order = mysqli_fetch_all($res)[0];

        $count = array($restaurant, $customer, $order);
        echo json_encode($count);
    }
}else{
    http_response_code(401);
}
?>