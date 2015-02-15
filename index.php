<?php
include("db.php");
require_once 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);

session_start();

if(isset($_SESSION['login_user'])) {
        $user = $_SESSION['login_user'];
}
else {
	$user = null;;
}

if(isset($_SESSION['url'])) {
	$link = $_SESSION['url'];
}
else {
	$link = null;
}

$db = new DB();
$conn = $db->connect();

$in = str_replace('/','',$_SERVER['REQUEST_URI']);

$sql = "SELECT * FROM urls WHERE code = '" . $in ."'" ;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	header("Location: " . $row['url']);	
	die();
}
else {
	$rows = array();
	$result = $db->getLatestUrl();
	$latestrow = $result->fetch_assoc();
	header('Content-Type: text/html');
	if($user === null){
		//$user = "guest";
		session_destroy();
	}
	echo $twig->render('index.html', array('link' => $link,'user' => $user, 'latesturl' => $latestrow ));
}
