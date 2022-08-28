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
            echo json_encode($res);
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
            //$newValue = $_POST;

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
            /*
            $menu = file_get_contents("php://input");
            $menu = json_decode($menu);
            $name = $menu->name;
            $description = $menu->description;
            $price = $menu->price;
            */

            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $rest_id = $_SESSION['userid'];
            //$photo = time(). "." . $_FILES['photo']['name'];
            $photo = time() . "." . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $folder = "uploads/photos/restaurant/menu/".$photo;
            if(!move_uploaded_file($_FILES['photo']['tmp_name'], $folder)){
                http_response_code(500);
                exit();
            }
            $query = "insert into menu(rest_id, name, description, price, state, photo)";
            $query .= " values($rest_id, '$name', '$description', $price, 'available', '$photo')";
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
            $res = mysqli_fetch_all($res);
            echo json_encode($res);
        }else{
            http_response_code(204);
        }
    }
}else{
    http_response_code(401);
}
?>