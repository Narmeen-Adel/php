<?php

require_once 'header.php';
require_once("autoload.php");
define("_ALLOW_ACCESS", 1);
$con = new MySQLI_DB("users");
$user=new User();
session_start();
session_regenerate_id();

require_once 'views\public\login.php';
require_once 'views\public\signup.php';


$user->validate_user();

//Routing

if (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] === true) {

    //admin views should be required here
    echo '<h1>this is Admin Page</h1> ';
    echo $_SESSION["user_id"];
    header('location:views\admin\users.php');
    exit();
} elseif (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] === false) {
    //members views should be required here
    echo '<h1>this is User Page</h1> ';
    echo $_SESSION["user_id"];
    header('location:views\member\view_my_profile.php');
    exit();
} else {
    
}
 
  