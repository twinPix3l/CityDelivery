<?php 

require "../common/functions.php";
session_start();

 $email =$_SESSION["user"];  
 $ora_ordine=$_GET["ora_ordine"];
 confirmOrders($cid,$email,$ora_ordine);
 header('location: ../frontend/checkOrder.php');
?>