<?php
session_start();
include('db/connect.php');

if(isset($_SESSION['userid'])) {
    if($_SESSION['account-type'] == "customer") {
        $action = $_GET['action'];
        if($action == 'place'){
            $order = file_get_contents('php://input'); 
            $order = json_decode($order, true); 
            //$user_id = $_SESSION['userid'];
            $rest_id = mysqli_real_escape_string($conn, $order->details->rest_id);
            $time_slot = mysqli_real_escape_string($conn, $order->details->time);
            $no_of_seats = mysqli_real_escape_string($conn, $order->details->seats);
            $items = mysqli_real_escape_string($conn, $order->items);
/*
            $rest_id = $_POST['rest_id'];
            $time_slot = $_POST['time'];
            $no_of_seats = $_POST['seats'];
*/
            

            $cust_id = $_SESSION['userid'];
            $time = date('y-m-d h:i:s');
            echo $time;
            $query = "insert into orders(cust_id, rest_id, date_and_time, total_price, ordered_on, seats, state)";
            $query .= " values($cust_id, $rest_id, '$time_slot', 0, '$time', $no_of_seats, 'processing')";
            if(mysqli_query($conn, $query)) {
                $order_id = mysqli_insert_id($conn);
                $count = count($items);
                $count_test = 0;
                foreach($items as $item) {
                    $menu_id = $item[0];
                    $menu_count = $item[1];
                    $query = "insert into ordered_menu(order_id, menu_id, count)";
                    $query .= " values($order_id, $menu_id, $menu_count)";
                    if(mysqli_query($conn, $query)) {
                        $count_test++;
                    }else{
                        $query = "delete from ordered_menu where order_id=$order_id";
                        mysqli_query($conn, $query);
                        break;
                    }
                }
                if($count == $count_test) {
                    $price = 0;
                    foreach($items as $item) {
                        $menu_id = $item[0];
                        $menu_count = $item[1];
                        $query = "select price from menu where id=$menu_id";
                        $res = mysqli_query($conn, $query);
                        $res = mysqli_fetch_assoc($res);
                        $price += $res['price'];
                    }
                    $query = "update orders set total_price=$price where id=$order_id";
                    if(mysqli_query($conn, $query)) {
                        $query = "update orders set status='requested' where id=$order_id";
                        mysqli_query($conn, $query);
                        http_response_code(201);
                    }
                }else{
                    $query = "update orders set status='failed' where id=$order_id";
                    mysqli_query($conn, $query);
                    http_response_code(500);
                }
            }
        }else if($action == 'fetch') {
            $user_id = $_SESSION['userid'];
            $query = "select * from orders where cust_id=$user_id order by id desc";
            $res = mysqli_query($conn, $query);
            if(mysqli_num_rows($res)>0) {
                $orders = array();
                while($order = mysqli_fetch_row($res)) {
                    $rest_id = $order[2];
                    $query = "select name from restaurant where id=$rest_id";
                    $result = mysqli_query($conn, $query);
                    $result = mysqli_fetch_row($result);
                    array_push($order, $result[0]);
                    array_push($orders, $order);
                }
                echo json_encode($orders);
            }
            
        }else if($action == 'cancel') {
            $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);
            $query = "select status from orders where id=$order_id";
            $res = mysqli_query($conn, $query);
            $status = mysqli_fetch_row($res);
            $status = $status[0];
            if($status == 'requested') {
                $query = "update orders set status='cancelled' where id=$order_id";
                if(mysqli_query($conn, $query)) {
                    http_response_code(202);
                }else{
                    http_response_code(500);
                }
            }
        }
        
    }else if($_SESSION['account-type'] == 'restaurant') {
        $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
        if($_POST['order_action'] == 'accept') {
            $query = "update orders set status='accepted' where id=$order_id";
            if(mysqli_query($conn, $query)) {
                http_response_code(202);
            }else{
                http_response_code(500);
            }
        }else if($_POST['order_action'] == 'reject') {
            $query = "update orders set status='rejected' where id=$order_id";
            if(mysqli_query($conn, $query)) {
                http_response_code(202);
            }else{
                http_response_code(500);
            }
        }
    }
} else {
    http_response_code(401);
}
mysqli_close($conn);
?>