<?php
session_start();
include('db/connect.php');
header("Content-Type: application/json");
if(isset($_SESSION['admin'])) {
    $type = $_GET['type'];
    $skip = mysqli_real_escape_string($conn, $_GET['skip']);
    if(isset($_GET['id'])) 
        $id = mysqli_real_escape_string($conn, $_GET['id']);
    else
        $id = '';

    if($type == 'restaurants') {
        if($id == '') 
            $query = "select id, name, address, location_link, email, phon_no, created, rating, photo, active from restaurant order by id desc limit $skip, 50";
        else
            $query = "select id, name, address, location_link, email, phon_no, created, rating, photo, active from restaurant where id=$id";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {   
            $restaurant = mysqli_fetch_all($res);
            echo json_encode($restaurant);
        }else{
            http_response_code(204);
        }
    }else if($type == 'customers') {
        if($id == '') 
            $query = "select id, name, dob, email, mobile_number, state, profile_photo, active from customer order by id desc limit $skip, 50";
        else
            $query = "select id, name, dob, email, mobile_number, state, profile_photo, active from customer where id=$id";
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
        if(!isset($_GET['comp_id']))
            $query = "select id, user_id, user_type, text, date_and_time from complaints  where hidden=0 order by id desc limit $skip, 50";
        else{
            $comp_id = mysqli_real_escape_string($conn, $_GET['comp_id']);
            $query = "select id, user_id, user_type, text, date_and_time from complaints  where id=$comp_id";
        }
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
        $restaurant = mysqli_fetch_all($res)[0][0];

        $query = "select count(id) from customer";
        $res = mysqli_query($conn, $query);
        $customer = mysqli_fetch_all($res)[0][0];

        $order = array();

        $query = "select count(id) from orders";
        $res = mysqli_query($conn, $query);
        $order[0] = mysqli_fetch_all($res)[0][0];

        $query = "select count(id) from orders where state='cancelled'";
        $res = mysqli_query($conn, $query);
        $order[1] = mysqli_fetch_all($res)[0][0];

        $query = "select count(id) from orders where state='rejected'";
        $res = mysqli_query($conn, $query);
        $order[2] = mysqli_fetch_all($res)[0][0];

        $query = "select count(id) from orders where state='accepted'";
        $res = mysqli_query($conn, $query);
        $order[3] = mysqli_fetch_all($res)[0][0];

        $query = "select count(id) from orders where state='confirmed'";
        $res = mysqli_query($conn, $query);
        $order[4] = mysqli_fetch_all($res)[0][0];

        $count = array($restaurant, $customer, $order[0], $order[1], $order[2], $order[3], $order[4]);
        echo json_encode($count);
    }
}else if(isset($_SESSION['userid'])) {
    if($_SESSION['account-type'] == 'customer') {
        $uid = $_SESSION['userid'];
        $query = "select id, name, dob, email, mobile_number, profile_photo from customer where id=$uid";
        $res = mysqli_query($conn, $query);
        $res = mysqli_fetch_assoc($res);
        echo json_encode($res);
    }
}else{
    http_response_code(401);
}
?>