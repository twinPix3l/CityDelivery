<?php

require "../common/functions.php";

session_start();

$dati = array();

$email = $_SESSION["user"];

$ristorante = $_POST["ristorante"];

$riga_ordine = $_POST["riga_ordine"];

$current_date = date('Y-m-d H:i:s', time());

deleteOpenOrders($cid, $email, $ristorante);
if (isset($riga_ordine) && count($riga_ordine) > 0) {
    insertOrdine($cid, $email, $current_date);
    $i = 0;
    foreach ($riga_ordine as $r) {
        insertRigaOrdine($cid, $i, $email, $current_date, $ristorante, $r['title'], $r['price'], $r['quantity']);
        $i++;
    }
}

header('location: ../frontend/basket.php');


?>