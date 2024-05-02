<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

$result = mysqli_query($cid, "SELECT DISTINCT * FROM Ordine
							  JOIN RigaOrdine ON Ordine.acquirente = RigaOrdine.acquirente
							  AND Ordine.ora_ordine = RigaOrdine.ora_ordine
							  WHERE RigaOrdine.ristorante = '".$email."'
							  AND (Ordine.stato = 'In composizione' 
							  OR Ordine.stato = 'In attesa di accettazione'
							  OR Ordine.stato = 'In attesa di conferma') ");

$inactiveOrders = array();

while ($row = mysqli_fetch_assoc($result)) {
	$orderLines = array();
	$orderLines_result = mysqli_query($cid, "SELECT DISTINCT nome_prodotto, prezzo, quantità FROM RigaOrdine 
											 WHERE acquirente = '" . $row['acquirente'] . "' 
                                             AND ora_ordine = '" . $row['ora_ordine'] . "' ");
	while ($orderLine = mysqli_fetch_assoc($orderLines_result)) {
		$orderLines[] = $orderLine;
	}
	$inactiveOrders[] = array(
		"acquirente" => $row['acquirente'],
		"ora_ordine" => $row['ora_ordine'],
		"stato"		 => $row['stato'],
		"orderLines" => $orderLines);
}

echo json_encode($inactiveOrders);

?>