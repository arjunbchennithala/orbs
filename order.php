<?php
session_start();
include('db/connect.php');
header("Content-Type: application/json");
if(isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
    if($_SESSION['account-type'] == "customer") {
        $action = $_GET['action'];
        if($action == 'place'){
            $order = file_get_contents('php://input'); 
            $order = json_decode($order, true); 
            
            $rest_id = mysqli_real_escape_string($conn, $order['details']['rest_id']);
            $time_slot = mysqli_real_escape_string($conn, $order['details']['time']);
            $no_of_seats = mysqli_real_escape_string($conn, $order['details']['seats']);
            $items = $order['item'];
            

            $cust_id = $_SESSION['userid'];
            $time = date('y-m-d h:i:s');

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
                        $price += $res['price'] * $menu_count;
                    }
                    $query = "update orders set total_price=$price where id=$order_id";
                    if(mysqli_query($conn, $query)) {
                        $query = "update orders set state='requested' where id=$order_id";
                        if(mysqli_query($conn, $query))
                            http_response_code(201);
                        else
                            http_response_code(403);
                    }
                }else{
                    $query = "update orders set state='failed' where id=$order_id";
                    mysqli_query($conn, $query);
                    http_response_code(500);
                }
            }
        }else if($action == 'fetch') {
            $user_id = $_SESSION['userid'];
            if(isset($_GET['filter'])){
                $filter = mysqli_real_escape_string($conn, $_GET['filter']);
                $query = "select * from orders where cust_id=$user_id and state='$filter' order by id desc";
            }else{
                $query = "select * from orders where cust_id=$user_id and state!='hidden' order by id desc";
            }
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
            }else{
                http_response_code(204);
            }
            
        }else if($action == 'cancel') {
            $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);
            $query = "select state from orders where id=$order_id";
            $res = mysqli_query($conn, $query);
            $status = mysqli_fetch_row($res);
            $status = $status[0];
            if($status == 'requested') {
                $query = "update orders set state='cancelled' where id=$order_id";
                if(mysqli_query($conn, $query)) {
                    http_response_code(202);
                }else{
                    http_response_code(500);
                }
            }else{
                http_response_code(403);
            }
        }else if($action == 'hide') {
            $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);
            $query = "update orders set state='hidden' where id=$order_id";
            if(mysqli_query($conn, $query)){
                http_response_code(201);
            }else{
                http_response_code(500);
            }
        }else if($action == 'orderedmenu') {
            $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);
            $query = "select * from ordered_menu where order_id=$order_id";
            $menus = mysqli_query($conn, $query);
            $menus = mysqli_fetch_all($menus);
            $men = array();
            foreach($menus as $menu) {
                $menu_id = $menu[2];
                $query = "select * from menu where id=$menu_id";
                $item = mysqli_query($conn, $query);
                $item = mysqli_fetch_all($item);
                array_push($item[0], $menu[3]);
                array_push($men, $item);
            }
            echo json_encode($men);
        }
        
    }else if($_SESSION['account-type'] == 'restaurant') {
        if(isset($_GET['order_id'])) {
            $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);
            if($_GET['action'] == 'accept') {
                $query = "update orders set state='accepted' where id=$order_id";
                if(mysqli_query($conn, $query)) {
                    http_response_code(202);
                    //header("Content-Type: text/html");
                    //echo "Successfully accepted";
                }else{
                    http_response_code(500);
                }
            }else if($_GET['action'] == 'reject') {
                $query = "update orders set state='rejected' where id=$order_id";
                if(mysqli_query($conn, $query)) {
                    http_response_code(202);
                    //header("Content-Type: text/html");
                    //echo "Successfully rejected";
                }else{
                    http_response_code(500);
                }
            }else if($_GET['action'] == 'confirm') {
                $query = "update orders set state='confirmed' where id=$order_id";
                if(mysqli_query($conn, $query)) {
                    http_response_code(202);
                }else{
                    http_response_code(500);
                }
            }else if($_GET['action'] == 'orderedmenu') {
                $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);
                $query = "select * from ordered_menu where order_id=$order_id";
                $menus = mysqli_query($conn, $query);
                $menus = mysqli_fetch_all($menus);
                $men = array();
                foreach($menus as $menu) {
                    $menu_id = $menu[2];
                    $query = "select * from menu where id=$menu_id";
                    $item = mysqli_query($conn, $query);
                    $item = mysqli_fetch_all($item);
                    array_push($item[0], $menu[3]);
                    array_push($men, $item);
                }
                echo json_encode($men);
            }
        }else{
            if(!isset($_GET['filter']))
                $query = "select * from orders where rest_id=$userid";
            else{
                $filter = mysqli_real_escape_string($conn, $_GET['filter']);
                $query = "select * from orders where rest_id=$userid and state='$filter'";
            }
            
            $res = mysqli_query($conn, $query);
            if(mysqli_num_rows($res)>0) {
                $res = mysqli_fetch_all($res);
                echo json_encode($res);
            }else{
                http_response_code(204);
            }
        }
    }
} else {
    http_response_code(401);
}
mysqli_close($conn);
?>
