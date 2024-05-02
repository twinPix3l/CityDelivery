<?php

require "../common/functions.php";

session_start();

$dati = array();
$errore = array();

$iva = $_POST["p_iva"];
$attività = $_POST["r_sociale"];
$zona = $_POST["zona"];
$sede = $_POST["s_legale"];
$indirizzo = $_POST["indirizzo"];


if (empty($iva) || strlen($iva) != 16)
{
	$errore["iva"] = "10";
	$dati["iva"] = "";
}
else
{
	$dati["iva"] = $iva;
}

if (empty($sede))
{
	$errore["sede"] = "5";
	$dati["sede"] = "";
}
else
{
	$dati["sede"] = $sede;
}

if (empty($indirizzo))
{
	$errore["indirizzo"] = "5";
	$dati["indirizzo"] = "";
}
else
{
	$dati["indirizzo"] = $indirizzo;
}

if (empty($attività))
{
	$errore["attività"] = "11";
	$dati["attività"] = "";
}
else
{
	$dati["attività"] = $attività;
}

if (!isset($_POST["zona"]) || $zona < 0 || $zona > 9)
{
	$errore["zona"] = "6";
	$dati["zona"] = "";
}		
else
	$dati["zona"] = $zona;

if (count($errore) > 0)
{
	header('location: ../frontend/seeProfileRistorante.php?status=ko&errore=' . serialize($errore). '&dati=' . serialize($dati));
}
else
{
	$email=$_SESSION["user"];
	updateRistorante($cid, $email, $iva, $attività, $zona, $sede, $indirizzo);
	
	header('location: ../frontend/seeProfileRistorante.php?status=ok&dati=' . serialize($dati));
}

?>