<?php

$user_login_id = $_SESSION['ews_logged_in'];
$user_login_role = $_SESSION['ews_logged_in_role'];

if(!isset($user_login_id)){
    header("location:login");
}

//include("role-assignment.php");

?>