<?php

require "../common/functions.php";

session_start();

$email = $_SESSION['user'];

$orders = getConfirmedOrders($cid, $email);

echo json_encode($orders);

?>