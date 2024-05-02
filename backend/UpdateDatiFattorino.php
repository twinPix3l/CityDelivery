<?php

require "../common/functions.php";

session_start();

$dati = array();
$errore = array();


$nome = $_POST["nome"];            // è buona norma cambiare nome dell'etichetta dei parametri che vengono passati per eventuali attacchi
$cognome = $_POST["cognome"];
$zona = $_POST["zona"];



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



if (!isset($_POST["zona"]) || $zona < 0 || $zona > 9)
{
	$errore["zona"] = "6";
	$dati["zona"] = "";
}		
else
	$dati["zona"] = $zona;


if (count($errore) > 0)
{
	header('location: ../frontend/seeProfileFattorino.php?status=ko&errore=' . serialize($errore). '&dati=' . serialize($dati));
}
else
{
	$email=$_SESSION["user"];
	updateFattorino($cid, $email, $nome, $cognome, $zona);
	
	header('location: ../frontend/seeProfileFattorino.php?status=ok&dati=' . serialize($dati));
}

?>