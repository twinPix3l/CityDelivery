<?php

require "../common/functions.php";

session_start();

$dati = array();
$errore = array();


$nome = $_POST["nome"];            // è buona norma cambiare nome dell'etichetta dei parametri che vengono passati per eventuali attacchi
$cognome = $_POST["cognome"];
$telefono = $_POST["telefono"];
$zona = $_POST["zona"];
$carta = $_POST["cartaCredito"];
$via = $_POST["via"];
$civico = $_POST["civico"];
$cap = $_POST["cap"];
$citofono = $_POST["citofono"];
$istruzioni = $_POST["istruzioniConsegna"];


if (empty($nome))
{
	$errore["nome"] = "3";
	$dati["nome"] = "";
}
else
{
	$dati["nome"] = $nome;
}

if (empty($cognome))
{
	$errore["cognome"] = "4";
	$dati["cognome"] = "";
}		
else
{
	$dati["cognome"] = $cognome;
}

if (empty($telefono))
{
	$errore["telefono"] = "9";
	$dati["telefono"] = "";
}		
else
{
	$dati["telefono"] = $telefono;
}

if (empty($via) || empty($civico) || empty($cap))
{
	$errore["indirizzo"] = "5";
}

$dati["via"] = $via;
$dati["civico"] = $civico;
$dati["cap"] = $cap;

if (!isset($_POST["zona"]) || $zona < 0 || $zona > 9)
{
	$errore["zona"] = "6";
	$dati["zona"] = "";
}		
else
	$dati["zona"] = $zona;

if (empty($carta))
{
	$errore["carta"] = "7";
	$dati["carta"] = "";
}		
else
	$dati["carta"] = $carta;

if (empty($citofono))
{
	$errore["citofono"] = "8";
	$dati["citofono"] = "";
}		
else
	$dati["citofono"] = $citofono;

if (!isset($_POST["istruzioniConsegna"]))
{
	$dati["istruzioni"] = "";
}
else
	$dati["istruzioni"] = $istruzioni;

if (count($errore) > 0)
{
	header('location: ../frontend/seeProfileAcquirente.php?status=ko&errore=' . serialize($errore). '&dati=' . serialize($dati));
}
else
{
	$email=$_SESSION["user"];
	updateAcquirente($cid, $email, $nome, $cognome, $carta, $via, $civico, $cap, $citofono, $istruzioni, $telefono, $zona);
	
	header('location: ../frontend/seeProfileAcquirente.php?status=ok&dati=' . serialize($dati));
}

?>