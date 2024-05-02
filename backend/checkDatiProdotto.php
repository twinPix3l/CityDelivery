<?php

require "../common/functions.php";
session_start();
$dati = array();
$errore = array();


$nome = $_POST["nome"];
$tipo =$_POST["tipo"];
$descrizione = $_POST["descrizione"];
$prezzo =$_POST["prezzo"];

$immagine =$_POST["immagine"];

if (empty($nome))
{
	$errore["nome"] = "3";            // assegno un numero al tipo di errore
	$dati["nome"] = "";
}
else
{
		$dati["nome"] = $nome;
}

if (empty("tipo"))
{
	$errore["tipo"] = "14";
	$dati["tipo"] = "";
}
else
{
	$dati["tipo"] = $tipo;
}
if (empty($descrizione))
{
	$errore["descrizione"] = "12";
	$dati["descrizione"] = "";
}
else
{
	$dati["descrizione"] = $descrizione;
}


if (empty($prezzo))
{
	$errore["prezzo"] = "13";
	$dati["prezzo"] = "";
}
else
{
	$dati["prezzo"] = $prezzo;
}

if (empty($immagine))
{
	$errore["immagine"] = "15";
	$dati["immagine"] = "";
}
else
{
	$dati["immagine"] = $immagine;
}

if (count($errore) > 0)
{
	header('location: ../frontend/datiProdotto.php?status=ko&errore=' . serialize($errore). '&dati=' . serialize($dati));
}
else
{
	// ---INSERT QUERY--- //
		$email=$_SESSION["user"];
	insertProdotto($cid,$email,$nome,$tipo,$descrizione,$prezzo,$immagine);
	
	header('location: ../frontend/homeRistorante.php?status=ok&dati=' . serialize($dati));
	
}

?>