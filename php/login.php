<?php

require "database.php";


$email = $_GET["email"];
$password = $_GET["password"];
$query = $conn->prepare("SELECT hash FROM members WHERE email=?");
$query->bind_param("s", $email);
$query->execute();
$query->bind_result($hash);
$query->fetch();

if (password_verify($password, $hash)) {
	die("logged in");
}
else {
	die("incorrect email or password");
}

$query->close();

?>