<?php
session_start();
include('db/connect.php');
header("Content-Type: application/json");
if(isset($_SESSION['userid'])) {
    if($_GET['type'] == 'post') {
        if($_SESSION['account-type'] == 'customer'){
            $cust_id = $_SESSION['userid'];
            $rest_id = mysqli_real_escape_string($conn, $_POST['rest_id']);
            $text = mysqli_real_escape_string($conn, $_POST['text']);
            $date = date('y-m-d');
            $query = "insert into reviews(cust_id, rest_id, text, date_and_time)";
            $query .= " values($cust_id, $rest_id, $text, $date)";
            if(mysqli_query($conn, $query)) {
                http_response_code(201);
            }else{
                http_response_code(500);
            }
        }else{
            http_response_code(403);
        }

    }else if($_GET['type'] == 'fetch') {
        $rest_id = mysqli_real_escape_string($conn, $_GET['rest_id']);
        $query = "select * from reviews where rest_id=$rest_id";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res)>0) {
            $reviews = mysqli_fetch_all($res);
            echo json_encode($reviews);
        }else{
            http_response_code(204);
        }
    }
}else{
    http_response_code(401);
}
?>