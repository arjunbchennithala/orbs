<?php
session_start();
include('db/connect.php');
if(isset($_SESSION['userid'])) {
    $type = $_GET['type'];
    $q = mysqli_real_escape_string($conn, $_GET['query']);
    if($type == 'restaurant') {
        $query = "select id, name, address, location_link, email, phon_no, rating from restaurant where LOCATE('$q', address) > 0 OR LOCATE('$q', name) > 0";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {
            $res = mysqli_fetch_assoc($res);
            $restaurants = array();
            //$photos = array();
            foreach($res as $restaurant) {
                $id = $restaurant['id'];
                $query = "select value from restaurant_photo where rest_id=$id";
                $photos = mysqli_query($conn, $query);
                $photos = mysqli_fetch_assoc($photos);
                array_push($restaurant, $photos);
                array_push($restaurants, $restaurant);
            }
            echo json_encode($restaurants);
        }else{
            http_response_code(204);
        }
    } else if($type == 'menu'){

        $rest_id = mysqli_real_escape_string($conn, $_GET['rest_id']);
        $q = mysqli_real_escape_string($conn, $_GET['query']);
        if($q == '') {
            $query = "select id, name, description, price from menu where rest_id=$rest_id and state='available'";
        }else{
        $query = "select id, name, description, price from menu where rest_id=$rest_id and state='available' and LOCATE('$q', name)>0";
        }

        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {
            $res = mysqli_fetch_assoc($res);
            $menus = array();
            foreach($res as $menu) {
                $menu_id = $menu['id'];
                $query = "select type, value from menu_photo where rest_id=$rest_id and menu_id=$menu_id";
                $result = mysqli_query($conn, $query);
                $result = mysqli_fetch_assoc($result);
                array_push($menu, $result);
                array_push($menus, $menu);
            }
            echo json_encode($menus);
        }else{
            http_response_code(204);
        }
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(401);
}

?>