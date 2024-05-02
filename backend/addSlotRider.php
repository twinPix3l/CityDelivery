<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

if (empty($_POST["day"]) || empty($_POST["slot"])) {
	header('Location: ../frontend/calendarRider.php?error=input');
} else {

	$day = $_POST["day"];
	$slot = $_POST["slot"];

	if ($day == "Monday")
		$day = "Lunedì";
	if ($day == "Tuesday")
		$day = "Martedì";
	if ($day == "Wednesday")
		$day = "Mercoledì";
	if ($day == "Thursday")
		$day = "Giovedì";
	if ($day == "Friday")
		$day = "Venerdì";
	if ($day == "Saturday")
		$day = "Sabato";
	if ($day == "Sunday")
		$day = "Domenica";

	if ($slot == "11:30 - 15:30")
		$slot = "Mattina";
	if ($slot == "15:30 - 19:30")
		$slot = "Pomeriggio";
	if ($slot == "19:30 - 23:30")
		$slot = "Sera";

	$num_rows = checkDisponibility($cid, $email, $day, $slot);

	if ($num_rows == 1) {
		header('Location: ../frontend/calendarRider.php?error=full');
	} else if ($num_rows == 0) {
		addDisponibility($cid, $email, $day, $slot);
		header('Location: ../frontend/calendarRider.php');
	}
}

?>