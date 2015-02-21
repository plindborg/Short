<?php
include("db.php");
require_once 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
session_start();
$user = $_POST['user'];
if(!isset($_SESSION['login_user'])) {
        $user = "guest";
}
$code = "";
$url = $_POST['url'];
if(isset($_POST['customcode'])) {
	$custom = trim($_POST['customcode']);	
}
else {
	$custom="";
}

if($url == "") {
	die();
}
if($custom === "") {
	for($i = 0; $i < 5; $i++) {
		$char = chr(rand(65,90));
		$code = $code . $char;	
	}
}
else {
	$code = $custom;
}

$db = new DB();
$conn = $db->connect();

$result = $db->insert($code,$url,$user);

if($result) {
	$link = 'http://'.$_SERVER['HTTP_HOST'] . "/" . $code;
	$_SESSION['url']= $link;
	header('Location: index.php');
	//echo $twig->render('post.html', array('link' => $link));
	//echo $code . " = " . $url . "<br>";
}
else {
	echo "Something went wrong" . "<br>";
}