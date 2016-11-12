<?php
header('Content-Type: application/json');
require_once 'cors.php';
require_once 'connection.php';

// sql injection attack
$username = $conn->real_escape_string($_POST['username']);

$sql = "
	SELECT username
	FROM users
	WHERE username = '{$username}'
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo json_encode(array(
		"result" => false,
		"errors" => array("User already exists")
	));
	die(0);
}

// insert data into database if no errors
$crypted_password = sha1($_POST['password']);

$sql = "
	INSERT INTO users (
		username, crypted_password, first_name,
		last_name, email, phone,
		country, province, city,
		age, gender, created_at
	) VALUES (
		'{$conn->real_escape_string($_POST['username'])}',
		'{$conn->real_escape_string($crypted_password)}',
		'{$conn->real_escape_string($_POST['first_name'])}',
		'{$conn->real_escape_string($_POST['last_name'])}',
		'{$conn->real_escape_string($_POST['email'])}',
		'{$conn->real_escape_string($_POST['phone'])}',
		'{$conn->real_escape_string($_POST['country'])}',
		'{$conn->real_escape_string($_POST['province'])}',
		'{$conn->real_escape_string($_POST['city'])}',
		'{$conn->real_escape_string($_POST['age'])}',
		'{$conn->real_escape_string($_POST['gender'])}',
		now()
	)
";

if ($conn->query($sql) === true) {
	$user_id = $conn->insert_id;
	$sql = "
		SELECT *
		FROM users
		WHERE id = {$user_id}
	";
	$result = $conn->query($sql);
	$user = $result->fetch_assoc();

	// 4) respond with JSON
	echo json_encode(array(
		"result" => true,
		"user" => $user
	));
} else {
	echo json_encode(array(
		"result" => false,
		"errors" => array("Error saving user {$conn->error}")
	));
}

