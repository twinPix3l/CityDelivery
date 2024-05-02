<?php

require "../common/functions.php";

session_start();

if (($_POST["tempistica_consegna"] == ""))
	header('Location: ../frontend/homeFattorino.php?error=input');

$email = $_SESSION["user"];
$acquirente = $_POST["acquirente"];
$ora_ordine = $_POST["ora_ordine"];
$tempistica_consegna = $_POST["tempistica_consegna"];
$current_time = date('H:i');

if ($tempistica_consegna <= $current_time) {
	header('Location: ../frontend/homeFattorino.php?error=input');
} else {
	acceptOrder($cid, $email, $acquirente, $ora_ordine, $current_time, $tempistica_consegna);
	header('location: ../frontend/homeFattorino.php');
}

?>