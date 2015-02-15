<?php
include("db.php");
require_once 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
session_start();

if(!isset($_SESSION['login_user'])) {
	echo $twig->render('admin.html', array('test' => 'Not logged in'));	
	die();
} else {
	$user = $_SESSION['login_user'];
}


$db = new DB();
$db->connect();
$result = $db->getAllUrls();
$rows = array();
while($row = $result->fetch_assoc()) {
//	echo $row['code'] . " " . $row['url'] . "<br> ";	
	$rows[] = $row;
}
//var_dump($rows);
echo $twig->render('admin.html', array( 'rows' => $rows, 'user' => $user ));
