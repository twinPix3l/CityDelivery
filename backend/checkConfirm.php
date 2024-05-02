<?php

require "../common/functions.php";

session_start();

$email = $_SESSION["user"];
$prev_state = $_GET["prev_state"];
$result = getOrderStateByRider($cid, $email);
$response = ["", ""];

if (($result == "In consegna") || ($result == "Annullato")) {
    if ($prev_state == $result)
        $response = ["not_changed", $result];
    else
        $response = ["changed", $result];
} else if ($result == "No order found") {
    $response = ["No order found", ""];
}

echo json_encode($response);

?>