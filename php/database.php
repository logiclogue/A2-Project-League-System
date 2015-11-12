<?php

$string = file_get_contents("../env.json");
$data = json_decode($string, true);
$connData = $data["database"];

$conn = new mysqli($connData["servername"], $connData["username"], $connData["password"], $connData["database"]);

if ($conn->connect_error) {
	die("Connection failed" . $conn->connect_error);
}

?>