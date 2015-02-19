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
if($user == 'admin') {
	$rows = $db->getAllUrls();
}
else {
	$rows = $db->getUserUrls($user);
}
echo $twig->render('user.html', array( 'rows' => $rows, 'user' => $user ));
