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
        }else if($type == 'fetch'){
            $rest_id = $_SESSION['userid'];
            if(isset($_GET['menu_id'])) {
                $menu_id = mysqli_real_escape_string($conn, $_GET['menu_id']);
                $query = "select * from menu where id=$menu_id";
            }else{
                $query = "select * from menu where rest_id=$rest_id";
            }
            $res = mysqli_query($conn, $query);
            $res = mysqli_fetch_all($res);
            $menus = array();
            foreach($res as $menu) {
                $query = "select type, value from menu_photo where rest_id=$rest_id and menu_id=$menu[0]";
                $menu_photo = mysqli_query($conn, $query);
                $menu_photo = mysqli_fetch_all($menu_photo);
                array_push($menu, $menu_photo);
                array_push($menus, $menu);
            }
            echo json_encode($menus);
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
            $newValue = file_get_contents('php://input'); 
            $newValue = json_decode($newValue, true); 

            $menu_id = mysqli_real_escape_string($conn, $_GET['menuid']);
            if($newValue['name'] != "") {
                $name = mysqli_real_escape_string($conn, $newValue['name']);
                $query = "update menu set name='$name' where id=$menu_id";
                mysqli_query($conn, $query);
            }
            if($newValue['description'] != "") {
                $description = mysqli_real_escape_string($conn, $newValue['description']);
                $query = "update menu set description='$description' where id=$menu_id";
                mysqli_query($conn, $query);
            }
            if($newValue['price'] != "") {
                $price = mysqli_real_escape_string($conn, $newValue['price']);
                $query = "update menu set price=$price where id=$menu_id";
                mysqli_query($conn, $query);
            }
        }else if($type == 'add'){
            $menu = file_get_contents("php://input");
            $menu = json_decode($menu);
            $name = $menu->name;
            $description = $menu->description;
            $price = $menu->price;
            $rest_id = $_SESSION['userid'];
            $query = "insert into menu(rest_id, name, description, price, state)";
            $query .= " values($rest_id, '$name', '$description', $price, 'available')";
            if(mysqli_query($conn, $query)) {
                http_response_code(201);
            }else{
                http_response_code(500);
            }

        }
    }else if($_SESSION['account-type'] == 'customer') {
        $rest_id = mysqli_real_escape_string($conn, $_GET['restid']);
        $query = "select * from menu where rest_id=$rest_id and state='available'";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {
            $menus = array();
            $res = mysqli_fetch_all($res);
            foreach($res as $menu){
                $query = "select * from menu_photo where menu_id=$menu[0]";
                $result = mysqli_query($conn, $query);
                if(mysqli_num_rows($result)>0) {
                    $result = mysqli_fetch_all($result);
                    array_push($menu, $result);
                }
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