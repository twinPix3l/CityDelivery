<?php

require "../common/functions.php";
session_start();

$email = $_SESSION["user"];  
$nome=$_GET["nome"];
deleteProdotto($cid,$email,$nome);
header('location: ../frontend/vissualiceProdotti.php?status=ok&dati=' . serialize($dati));

?>