<?php
header('Content-Type: application/json');
require_once 'cors.php';
require_once 'connection.php';

// 1) receive the params submitted from form

// 2) validate the params
// a) does this user already exist?

// Make connection to db
$conn = new mysqli('127.0.0.1', 'root', '', 'mycms');
// check connection
if ($conn->connect_error) {
	echo json_encode(array(
		"result" => false,
		"errors" => array("Can't connect to database")
	));
	die(0);
}

// sql injection attack
$username = $conn->real_escape_string($_POST['username']);

$sql = "
	SELECT *
	FROM users
	WHERE username = '{$username}'
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$user = $result->fetch_assoc();
	// Compare crypted passwords
	if (sha1($_POST['password']) === $user['crypted_password']) {
		// username and password are correct
		echo json_encode(Array(
			"result" => true,
			"user" => $user
		));
		die(0);
	}
}

echo json_encode(array(
	"result" => false,
	"errors" => array("Username or password incorrect")
));
