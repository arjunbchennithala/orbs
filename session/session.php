<?php

include("db/connect.php");

function isValid($sid) {
    $query = "select * from session where sess_id='" . $sid . "'";
    $res = mysqli_query($conn, $query);
    if(mysqli_num_rows($res) > 0) {
        $res = mysqli_fetch_assoc($res);
        if($res['active'] == 'true') {
            return true;
        }
    }
    return false;
}


function getDetails($sid) {
    $query = "select * from session where sess_id='" . $sid . "'";
    $res = mysqli_query($conn, $query);
    if(mysql_num_rows($res)>0) {
        $row = mysqli_fetch_assoc($res);
        return $row;
    }
}

function createSession($uid, $utype) {
    if($utype=='restaurant')
        $query = "select * from restaurant where id='" . $uid ."'";
    else if($utype=='customer') 
        $query = "select * from customer where id='" . $uid ."'";
    $res = mysqli_query($conn, $query);
    $res = mysqli_fetch_assoc($res);
    $email = $res['email'];
    $time = time();
    $text = $email . $time;
    $hash = hash('md5', $text);
    $date = date();
    $ip = $_SERVER['REMOTE_ADDR'];
    $query = "insert into session(sess_id, uid, utype, created_on, ip_address, active)";
    $query .= " values('". $hash ."', " . $uid . ", '" . $utype . "', '" . $date ."', '" . $ip . "', 'true')";
    $res = mysqli_query($conn, $query);
}

function deleteSession($sid) {
    $query = "update session set active='false' where session_id='" . $sid . "'";
    if(mysqli_query($conn, $query)) {
        return true;
    }else {
        return false;
    }
}


function activeSessions($sid) {
    $res = getDetails($sid);
    $uid = $res['uid'];
    $utype = $res['utype'];
    $query = "select * from session where uid=" . $uid . " AND utype='" . $utype . "' AND active='true'";
    $res = mysqli_query($conn, $query);
    return $res;
}


function deleteSessions($sid) {
    $active = activeSessions($sid);
    while($row = mysqli_fetch_assoc($active)) {
        if($row['sid'] != $sid) 
            deleteSession($row['sid']);
    }
}

?>