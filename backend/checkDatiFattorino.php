<?php

require "../common/functions.php";

session_start();
$dati = array();
$errore = array();

$email = $_POST["email"];
$password = $_POST["pwd"];

$nome = $_POST["nome"];            // è buona norma cambiare nome dell'etichetta dei parametri che vengono passati per eventuali attacchi
$cognome = $_POST["cognome"];
$zona = $_POST["zona"];

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
	header('location: ../frontend/datiFattorino.php?status=ko&errore=' . serialize($errore). '&dati=' . serialize($dati));
}
else
{
	// ---INSERT QUERY--- //
        insertFattorino($cid, $email, $password, $nome, $cognome, $zona);
	// ---Homepage per Fattorino--- //
		$_SESSION["user"] = $email;
        header('location: ../frontend/homeFattorino.php?status=ok&dati=' . serialize($dati));
}

?>