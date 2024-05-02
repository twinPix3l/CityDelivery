<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

$current_day = date("Y-m-d");
$current_time = date('H:i:s');
$current_time = strtotime($current_time);

$result = mysqli_query($cid, "SELECT DISTINCT * FROM Ordine
							  JOIN RigaOrdine ON Ordine.acquirente = RigaOrdine.acquirente
							  AND Ordine.ora_ordine = RigaOrdine.ora_ordine
							  WHERE RigaOrdine.ristorante = '" . $email . "'
							  AND Ordine.stato = 'Consegnato' ");

$closedOrders = array();

while ($row = mysqli_fetch_assoc($result)) {
	$orderLines = array();

	$orderLines_result = mysqli_query($cid, "SELECT DISTINCT nome_prodotto, prezzo, quantità FROM RigaOrdine 
											 WHERE acquirente = '" . $row['acquirente'] . "' 
                                             AND ora_ordine = '" . $row['ora_ordine'] . "' ");

	while ($orderLine = mysqli_fetch_assoc($orderLines_result)) {
		$orderLines[] = $orderLine;
	}
	$dt = new DateTime($row["ora_ordine"]);
    $order_day = $dt->format('Y-m-d');
	if (($current_day == $order_day) && ($current_time - strtotime($row["ora_ordine"]) <= 7199)) {
		$closedOrders[] = array(
			"acquirente" => $row['acquirente'],
			"ora_ordine" => $row['ora_ordine'],
			"stato" => $row['stato'],
			"orderLines" => $orderLines
		);
	}
}

echo json_encode($closedOrders);

?>