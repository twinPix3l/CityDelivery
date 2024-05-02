<?php

require "../common/functions.php";
session_start();

$email =$_SESSION["user"];  
$ora_ordine=$_GET["ora_ordine"];
deleteOrdine($cid,$email,$ora_ordine);
header('location: ../frontend/basket.php');

?>