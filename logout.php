<?php
session_start();
session_destroy();
// Store Session Data
//if(isset($_SESSION['login_user']))
//	unset($_SESSION['login_user']);
header('Location: index.php');
