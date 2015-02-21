<?php
include("db.php");

$db = new DB();
$conn = $db->connect();

$username = $_POST["user_name"];
$password = $_POST["password"];

if($db->login($username, $password) ) {
	// Store Session Data
	echo 'true';
	session_start();
	$_SESSION['login_user']= $username;
}
else {
	echo 'false';
}
//header("Location: index.php");
