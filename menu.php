<?php
session_start();
include('db/connect.php');
header("Content-Type: application/json");
if(isset($_SESSION['userid'])) {
    if($_SESSION['account-type'] == 'restaurant') {
        $type = $_GET['type'];
        if($type == 'create') {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = mysqli_real_escape_string($conn, $_POST['price']);
            $rest_id = $_SESSION['userid'];
            $query = "insert into menu(name, description, price, rest_id, state)";
            $query .= " values('$name', '$description', $price, $rest_id, 'available')";
            if(mysqli_query($conn, $query)) {
                http_response_code(201);
            }else{
                http_response_code(500);
            }
        }else if($type == 'hide') {
            $menu_id = mysqli_real_escape_string($conn, $_GET['menuid']);
            $query = "update menu set state='unavailable' where id=$menu_id";
            if(mysqli_query($conn, $query)) 
                http_response_code(202);
            else
                http_response_code(500);
        }else if($type == 'unhide') {
            $menu_id = mysqli_real_escape_string($conn, $_GET['menuid']);
            $query = "update menu set state='available' where id=$menu_id";
            if(mysqli_query($conn, $query)) 
                http_response_code(202);
            else
                http_response_code(500);
        }else if($type == 'edit') {
            $menu_id = mysqli_real_escape_string($conn, $_GET['menuid']);
            if(isset($_POST['name'])) {
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $query = "update menu set name='$name' where id=$menu_id";
                mysqli_query($conn, $query);
            }
            if(isset($_POST['description'])) {
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $query = "update menu set description='$description' where id=$menu_id";
                mysqli_query($conn, $query);
            }
            if(isset($_POST['price'])) {
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $query = "update menu set price=$price where id=$menu_id";
                mysqli_query($conn, $query);
            }
        }
    }else if($_SESSION['account-type'] == 'customer') {
        $rest_id = mysqli_real_escape_string($conn, $_GET['restid']);
        $query = "select * from menu where rest_id=$rest_id";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {
            $menus = array();
            $res = mysqli_fetch_all($res);
            foreach($res as $menu){
                $query = "select * from menu_photo where menu_id=$menu[0] and state='available'";
                $result = mysqli_query($conn, $query);
                $result = mysqli_fetch_all($result);
                array_push($menu, $result);
                array_push($menus, $menu);
            }
            echo json_encode($menus);
        }else{
            http_response_code(204);
        }
    }
}else{
    http_response_code(401);
}
?>