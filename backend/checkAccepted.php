<?php

require "../common/functions.php";

session_start();

$email = $_SESSION['user'];

$acceptedOrders = getAcceptedOrders($cid, $email);

echo json_encode($acceptedOrders);

?>