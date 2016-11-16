<?php
header('Content-Type: application/json');
require_once 'cors.php';
require_once 'connection.php';

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
