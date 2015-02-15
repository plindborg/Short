<?php
include("db.php");

$db = new DB();
$conn = $db->connect();

session_start();

$username = $_POST["user_name"];
$password = $_POST["password"];

if($db->login($username, $password) ) {
	// Store Session Data
	$_SESSION['login_user']= $username;
}
header("Location: index.php");
