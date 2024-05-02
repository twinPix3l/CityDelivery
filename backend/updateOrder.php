<?php 

require "../common/functions.php";
session_start();

$email = $_SESSION["user"];  
$ora_ordine = $_POST["ora_ordine"];
$metodo_pagamento = $_POST["metodo_pagamento"];
payment($cid,$email,$ora_ordine,$stato,$metodo_pagamento);
header('location: ../frontend/checkOrder.php');

?>