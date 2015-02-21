<?php

class DB {

private $conn;

public function __construct()
{
}

public function insertUser($user_name, $password) {
// INSERT INTO users (user_name,password) VALUES('lindborg', 'test');

        $query = "INSERT INTO users(user_name, password) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        if($stmt != false)
        {
                $stmt->bind_param('ss', $user_name, $password);
                if ($stmt->execute() === TRUE) {
                        //echo "New record created nuccessfully" . "<br>" ;
                        return true;
                } else {
                        //echo "Error: " . $sql . "<br>" . $conn->error;
                        return false;
                }
        }
        else {
                return false;
        }
}

public function getLatestUrl() {
        $sql = "SELECT * FROM urls ORDER BY id DESC LIMIT 1 ";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0) {
                return $result;
        }
        return false;
}

public function getAllUrls() {
	$sql = "SELECT * FROM urls";
	$result = $this->conn->query($sql);
	if($result->num_rows > 0) {
		return $result;
	}
	return false;
}

public function findUrl($in) {
    //var_dump($in);
    $sql   = "SELECT code,url,user,accessed FROM urls WHERE code = ?";
    //var_dump($sql);
    //echo '--';
    $stmt  = $this->conn->prepare($sql);
    //var_dump($stmt);
    $stmt->bind_param('s', $in);
    $stmt->execute();
    $stmt->bind_result($code ,$url, $user,$accessed);
    $rows  = array();
    while($stmt->fetch()) {
        $rows = array(  "code" => $code, "url" => $url, "user" => $user, "accessed" => $accessed);
    }
    //var_dump($rows);
    return $rows;
}

public function getUserUrls($username) {
    $sql = "SELECT code,url,user FROM urls WHERE user = ?";
    $stmt  = $this->conn->prepare($sql);
	$stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($code ,$url, $user);
    $row = false;
	while($stmt->fetch()) {
		$row[] = array(  "code" => $code, "url" => $url, "user" => $user);
	}
	return $row;
}

public function connect() {

// Remove below
$servername = "localhost";
$username   = "dbuser";
$password   = "urlshortner";
$dbname     = "urlshortner";
// Create connection
$this->conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($this->conn->connect_error) {
    die("Connection failed: " . $this->conn->connect_error);
}
//echo "Connected successfully";
// remove above
return $this->conn;
}

public function insert($code,$url, $user) {
	$sql = "INSERT INTO urls (id, code, url, user) VALUES (NULL,'" . $code . "','" . $url . "','" . $user  . "')";

	if ($this->conn->query($sql) === TRUE) {
    		//echo "New record created successfully" . "<br>" ;
		return true;
	} else {
    		//echo "Error: " . $sql . "<br>" . $conn->error;
		return false;
	}
}

public function login($username, $password) {
    if ($password == "" || $username == "") {
        return false;
    }

    $sql   = "SELECT user_name, password FROM users where user_name = ?";
	$stmt  = $this->conn->prepare($sql);
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($$user,$passwd);
	$stmt->fetch();
	
	if($passwd == $password) {
		return true; 
	}
	return false; 
}

public function updateUrlCounter($code, $counter) {
    $sql = "UPDATE urls SET accessed = ? WHERE code = ?";
    $stmt  = $this->conn->prepare($sql);
    $stmt->bind_param('is', $counter, $code);
    $stmt->execute();
}

}
