<?php

session_start();
include("db/connect.php");
if((!isset($_SESSION['admin'])) && (!isset($_SESSION['userid'])))
{
    if($_GET['type'] == 'fetch') {
        $email = mysqli_real_escape_string($conn, $_GET['email']);
        if($_GET['user-type'] == 'restaurant')
            $query = "select question from restaurant where email=$email";
        else if($_GET['user-type'] == 'customer')
            $query = "select question from customer where email=$email";
        $question = mysqli_query($conn, $query);
        if(mysqli_num_rows($question)>0) {
            $question = mysqli_fetch_assoc($question);
            echo json_encode($question);
        }else{
            http_response_code(204);
        }    
    }
}else{
    if(isset($_SESSION['admin'])) {
        if($_SESSION['admin'] == true) {
            if($_GET['type'] == 'deactivate') {
                if($_GET['account'] == 'restaurant') {
                    $id = mysqli_real_escape_string($conn, $_GET['id']);
                    $query = "update restaurant set active=0 where id=$id";
                    mysqli_query($conn, $query);
                }else if($_GET['account'] == 'customer') {
                    $id = mysqli_real_escape_string($conn, $_GET['id']);
                    $query = "update customer set active=0 where id=$id";
                    mysqli_query($conn, $query);
                }
            }else if($_GET['type'] == 'activate') {
                if($_GET['account'] == 'restaurant') {
                    $id = mysqli_real_escape_string($conn, $_GET['id']);
                    $query = "update restaurant set active=1 where id=$id";
                    mysqli_query($conn, $query);
                }else if($_GET['account'] == 'customer') {
                    $id = mysqli_real_escape_string($conn, $_GET['id']);
                    $query = "update customer set active=1 where id=$id";
                    mysqli_query($conn, $query);
                }
            }
        }
    }
    if(isset($_SESSION['userid'])) {
        if($_GET['type'] == "restaurant") {
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $query = "select id, name, address, location_link, email, phon_no, photo, created from restaurant where id=$id";
            $result = mysqli_query($conn, $query);
            echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
        }if($_GET['type'] == "customer") {
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $query = "select name, profile_photo from customer where id=$id";
            $result = mysqli_query($conn, $query);
            echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
        }
    }
}

?>