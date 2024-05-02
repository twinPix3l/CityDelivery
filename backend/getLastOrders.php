<?php

require "../common/functions.php";

session_start();

$email = $_SESSION["user"];

$response = getLastOrdersByRider($cid, $email);

echo json_encode($response);

?>