<?php

require "../common/functions.php";

session_start();

// Get the data from the request
$email = $_SESSION['user'];

// Perform the queries
$zona = getRiderZone($cid, $email);
$orders = getPendingOrdersByZone($cid, $zona);

// Return the result as a JSON-encoded string
echo json_encode($orders);

?>