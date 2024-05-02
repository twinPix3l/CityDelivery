<?php 
require "../common/functions.php";
session_start();

 $email =$_SESSION["user"];  
 $ora_ordine=$_GET["ora_ordine"];
 $metodo_pagamento=$_GET["metodo_pagamento"];
 payment($cid,$email,$ora_ordine,$stato,$metodo_pagamento);
 header('location: ../frontend/basket.php?status=ok&dati=' . serialize($dati));
?>