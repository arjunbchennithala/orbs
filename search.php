<?php
session_start();
include('db/connect.php');
header("Content-Type: application/json");
if(isset($_SESSION['userid'])) {
    $type = $_GET['type'];
    $q = mysqli_real_escape_string($conn, $_GET['query']);

    if($type == 'restaurant') {
        $query = "select id, name, address, location_link, email, phon_no, rating from restaurant where LOCATE('$q', address) > 0 OR LOCATE('$q', name) > 0";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {
            $restaurants = array();
            while($restaurant = mysqli_fetch_row($res)) {
                $id = $restaurant[0];
                $query = "select value from restaurant_photo where rest_id=$id";
                $photos = mysqli_query($conn, $query);
                $photos = mysqli_fetch_all($photos);
                array_push($restaurant, $photos);

                array_push($restaurants, $restaurant);
            }
            echo json_encode($restaurants);
        }else{
            http_response_code(204);
        }
    } else if($type == 'customer'){
        $query = "select id, name, email, mobile_number, state, created from customer where LOCATE('$q', name) > 0 or LOCATE('$q', email) > 0";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {
            $customers = mysqli_fetch_all($res);
            echo json_encode($customers);
        }else{
            http_response_code(204);
        }
    }else {
        http_response_code(400);
    }
} else {
    http_response_code(401);
}
mysqli_close($conn);
?>