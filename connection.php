<?php

if (getenv("CLEARDB_DATABASE_URL")) {
	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$server = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$db = substr($url["path"], 1);
} else {
	$server = '127.0.0.1';
	$username = 'root';
	$password = '';
	$db = 'mycms';
}


// Make connection to db
$conn = new mysqli($server, $username, $password, $db);
// check connection
if ($conn->connect_error) {
	echo json_encode(array(
		"result" => false,
		"errors" => array("Can't connect to database")
	));
	die(0);
}