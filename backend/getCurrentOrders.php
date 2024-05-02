<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

//fetch data from orders table
$result = mysqli_query($cid, "SELECT DISTINCT * FROM Ordine
							  JOIN RigaOrdine ON Ordine.acquirente = RigaOrdine.acquirente
							  AND Ordine.ora_ordine = RigaOrdine.ora_ordine
							  WHERE RigaOrdine.ristorante = '".$email."'
							  AND Ordine.stato = 'In consegna' ");

//create an array to store the orders
$currentOrders = array();

//iterate through the results
while ($row = mysqli_fetch_assoc($result)) {
	//create an array for the current order's dishes
	$orderLines = array();
	//fetch data from dishes table
	$orderLines_result = mysqli_query($cid, "SELECT DISTINCT nome_prodotto, prezzo, quantità FROM RigaOrdine 
											 WHERE acquirente = '".$row['acquirente']."' 
                                             AND ora_ordine = '".$row['ora_ordine']."' ");
	//iterate through the dishes
	while ($orderLine = mysqli_fetch_assoc($orderLines_result)) {
		//add the dish to the array of dishes for the current order
		$orderLines[] = $orderLine;
	}
	//add the array of dishes for the current order to the orders array
	$currentOrders[] = array(
		"acquirente" => $row['acquirente'],
		"ora_ordine" => $row['ora_ordine'],
		"stato"		 => $row['stato'],
		"orderLines" => $orderLines);
}

echo json_encode($currentOrders);

?>