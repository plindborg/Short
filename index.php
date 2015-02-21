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

$result = $db->findUrl($in);

if ($result != false && $in != "") {
	//$row = $result->fetch_assoc();

	$counter = $result['accessed'];

	if(is_null($counter)) {
		$counter = 1;
	}
	else {
		$counter = $counter + 1;
	}
	$db->updateUrlCounter($result['code'], $counter);

	header("Location: " . $result['url']);	
	die();
}
else {
	$rows = array();
	$result = $db->getLatestUrl();
  	if($result != null) {
	  $latestrow = $result->fetch_assoc();
  	}
  	//header('Content-Type: text/html');
	if($user === null){
		session_destroy();
	}
	echo $twig->render('index.html', array('link' => $link,'user' => $user, 'latesturl' => $latestrow ));
}
