<?php
session_start();
include('db/connect.php');
header("Content-Type: application/json");
if(isset($_SESSION['userid'])){
    if(isset($_GET['post'])){
        $user_id = $_SESSION['userid'];
        $user_type = $_SESSION['account-type'];
        //$text = mysqli_real_escape_string($conn, $_POST['text']);
        $file = file_get_contents("php://input");
        $text = mysqli_real_escape_string($conn, $file);
        $date = date('y-m-d');
        $query = "insert into complaints(user_id, user_type, text, date_and_time)";
        $query .= " values($user_id, '$user_type', '$text', '$date')";
        if(mysqli_query($conn, $query)) 
            http_response_code(201);
        else
            http_response_code(500);
    }
}
if(isset($_SESSION['admin'])){
    if($_SESSION['admin'] == true){
        if($_GET['action']=='hide') {
            $comp_id = mysqli_real_escape_string($conn, $_GET['comp_id']);
            echo $comp_id;
            $query = "update complaints set hidden=1 where id=$comp_id";
            echo $query;
            echo mysqli_query($conn, $query);
        }
    }
}
?>
