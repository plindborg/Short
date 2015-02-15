<?php
include("db.php");
$db = new DB();
$conn = $db->connect();

$user_name = $_POST["user_name"];
$password = $_POST["password"];

if($db->insertUser($user_name, $password))
	header("Location: index.php");
