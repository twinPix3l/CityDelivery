<?php

require "../common/functions.php";

session_start();

$email = $_SESSION["user"];

$response = getPastOrdersByRider($cid, $email);

echo json_encode($response);

?>