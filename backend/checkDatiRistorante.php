<?php

require "../common/functions.php";

session_start();
$dati = array();
$errore = array();

$email = $_POST["email"];
$password = $_POST["pwd"];

$iva = $_POST["p_iva"];
$attività = $_POST["r_sociale"];
$zona = $_POST["zona"];
$sede = $_POST["s_legale"];
$indirizzo = $_POST["indirizzo"];

if (empty($email))
{
	$errore["email"] = "1";            // assegno un numero al tipo di errore
	$dati["email"] = "";
}
else
{
    	// check if e-mail address is well-formed
    	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      		$errore["email"] = "1";
		$dati["email"] = "";
    	}
	else
		$dati["email"] = $email;
}

if (empty($password) || strlen($password) < 8 || strlen($password) > 50)
{
	$errore["password"] = "2";
	$dati["password"] = "";
}
else
{
	$dati["password"] = $password;
}

if (empty($iva) || (strlen($iva) != 16 && strlen($iva) != 11))
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
	header('location: ../frontend/datiRistorante.php?status=ko&errore=' . serialize($errore). '&dati=' . serialize($dati));
}
else
{
	insertRistorante($cid,$email,$password,$iva,$attività,$zona,$sede,$indirizzo);
	$_SESSION["user"] = $email;
	header('location: ../frontend/homeRistorante.php?status=ok&dati=' . serialize($dati));
}

?>