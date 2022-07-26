<?php
session_start();
include('db/connect.php');
if(isset($_SESSION['userid'])){
    if($_SESSION['account-type'] == 'customer') {
        $user_id = $_SESSION['userid'];
        $rest_id = mysqli_real_escape_string($conn, $_POST['rest_id']);
        $text = mysqli_real_escape_string($conn, $_POST['text']);
        $date = date('y-m-d');
        $query = "insert into complaints(rest_id, cust_id, text, date_and_time)";
        $query .= " values($rest_id, $user_id, $text, $date)";
        if(mysqli_query($conn, $query){
		http_response_code(201);
        }else{
        	http_response_code(500);
        }
    }else if($_SESSION['account-type'] == 'restaurant') {
	$rest_id = $_SESSION['userid'];
	$query = "select * from complaints where rest_id=$rest_id order by id desc";
	$res = mysqli_query($conn, $query);
	if(mysqli_num_rows($res)>0) {
		echo json_encode(mysqli_fetch_all($res);
	}else{
		http_response_code(204);
	}
    }
}else{
	http_response_code(401);
}
?>

