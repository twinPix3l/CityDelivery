<?php

require "db_connection.php";
require "../backend/db_config.php";

$result = dbConnection();
$cid = $result["value"];

function visualizzaErrore($chiave)
{
    global $errore,$tipoErrore;
    if (isset($errore[$chiave])) echo "<err>" . $tipoErrore[$errore[$chiave]] . "</err>"; 
}

$tipoErrore = array("1" => "invalid email address",
                    "2" => "invalid password",
		            "3" => "invalid name",
		            "4" => "invalid surname",
		            "5" => "invalid address",
                    "6" => "invalid zone",
                    "7" => "invalid card number",
                    "8" => "invalid intercom",
                    "9" => "invalid phone number",
                    "10" => "invalid VAT number",
                    "11" => "invalid activity name",
                    "12" =>"invalid description",
                    "13" =>"invalid price",
                    "14" =>"invalid type",
                    "15" =>"invalid image");
$errore = array();
$dati = array();

if (isset($_GET["status"]))
{
	if ($_GET["status"] == "ko")
    {
        $errore = unserialize($_GET["errore"]);
	    $dati = unserialize($_GET["dati"]);
        //print_r($dati);
        //print_r($errore);
    }
}
else
{
	$dati["email"] = "";
    $dati["password"] = "";
	$dati["nome"] = "";
    $dati["cognome"] = "";
    $dati["telefono"] = "";
    $dati["zona"] = "";
    $dati["carta"] = "";
    $dati["via"] = "";
    $dati["civico"] = "";
    $dati["cap"] = "";
    $dati["citofono"] = "";
    $dati["istruzioni"] = "";
    $dati["iva"] = "";
    $dati["attività"] = "";
    $dati["tipo"] = "";
    $dati["descrizione"] = "";
    $dati["prezzo"] = "";
    $dati["immagine"] = "";
}

function insertAcquirente($cid, $email, $password, $nome, $cognome, $carta, $via, $civico, $cap, $citofono, $istruzioni, $telefono, $zona)
{
	$insert_stmt = "INSERT INTO Acquirente (email, psw, nome, cognome, data_registrazione, carta_credito, via, civico, cap, citofono, istruzioni_consegna, telefono, zona)
                    VALUES ('" .$email. "', '" .$password. "', '" .$nome. "', '" .$cognome. "', DEFAULT(data_registrazione), '" .$carta. "', '" .$via. "', '" .$civico. "', '" .$cap. "', '" .$citofono. "', '" .$istruzioni. "', '" .$telefono. "', '" .$zona. "')";
    if ($cid->query($insert_stmt) == TRUE)
    {
        echo "Registration successful";
    }
    else
    {
        echo "Error: " . $insert_stmt . "<br>" . $cid->error;
    }
}

function insertRistorante($cid, $email, $password, $iva, $attività, $zona, $sede, $indirizzo)
{
    $insert_stmt = "INSERT INTO Ristorante (email, psw, p_iva, r_sociale, zona, sede_legale, ind_completo)
                    VALUES ('" .$email. "', '" .$password. "', '" .$iva. "', '" .$attività. "', '" .$zona. "', '" .$sede. "', '" .$indirizzo. "')";
    if ($cid->query($insert_stmt) == TRUE)
    {
        echo "Registration successful";
    }
    else
    {
        echo "Error: " . $insert_stmt . "<br>" . $cid->error;
    }
}

function insertFattorino($cid, $email, $password, $nome, $cognome, $zona)
{
    $insert_stmt = "INSERT INTO Fattorino (email, psw, nome, cognome, zona_operata) 
                    VALUES ('" .$email. "', '" .$password. "', '" .$nome. "', '" .$cognome. "', '" .$zona. "')";
    if ($cid->query($insert_stmt) == TRUE)
    {
        echo "Registration successful";
    }
    else
    {
        echo "Error: " . $insert_stmt . "<br>" . $cid->error;
    }
}
function insertProdotto($cid, $email, $nome, $tipo, $descrizione, $prezzo, $immagine)
{
    $insert_stmt = "INSERT INTO Prodotto (ristorante, nome, tipo, descrizione, prezzo, immagine)
                    VALUES ('".$email. "','" .$nome. "', '" .$tipo. "', '" .$descrizione. "', '" .$prezzo. "',  '" .$immagine. "')";
    if ($cid->query($insert_stmt) == TRUE)
    {
        echo "Insert successful";
    }
    else
    {
        echo "Error: " . $insert_stmt . "<br>" . $cid->error;
    }
}

function getBuyerZone ($cid, $email)
{
    $result = $cid->query("SELECT zona FROM Acquirente WHERE email = '".$email."'");
    $row = $result->fetch_row();
    $zona = $row[0];
    return $zona;
}

function getRestaurantsByZone ($cid,$zona)
{
    $days = [
        'Domenica',
        'Lunedì',
        'Martedì',
        'Mercoledì',
        'Giovedì',
        'Venerdì',
        'Sabato',
    ];
    $now = time();
    $restaurants = [];
    $current_day = $days[idate('w', $now)];
    $current_hour = idate('H', $now);
    $current_minute = idate('i', $now);
    $current_daySlot = '';
    if (($current_hour == 19 && $current_minute >= 30) || ($current_hour > 19 && $current_hour < 23) || ($current_hour == 23 && $current_minute <= 30)) 
    {
        $current_daySlot = 'Sera';
    }
    else if (($current_hour == 15 && $current_minute >= 30) || ($current_hour > 15 && $current_hour < 19) || ($current_hour == 19 && $current_minute <= 30)) 
    {
        $current_daySlot = 'Pomeriggio';
    }
    else if (($current_hour == 11 && $current_minute >= 30) || ($current_hour > 11 && $current_hour < 15) || ($current_hour == 15 && $current_minute <= 30))
    {
        $current_daySlot = 'Mattina';
    }
    else
    {
        $current_daySlot = 'Notte';
    }
    $result = $cid->query(
        "SELECT Ristorante.r_sociale, Ristorante.ind_completo, Apertura.ristorante, Ristorante.email "
      . "FROM Ristorante LEFT OUTER JOIN Apertura ON (Ristorante.email = Apertura.ristorante "
      . "AND Apertura.giorno = '" . $current_day . "' "
      . "AND Apertura.orario = '" . $current_daySlot . "' ) "
      . "WHERE zona = '" . $zona . "' ");

    while($row = $result->fetch_row())
    {
        $restaurant = ["r_sociale"=>$row[0],
                       "indirizzo"=>$row[1],
                       "stato"=>$row[2]==null ? "Chiuso" : "Aperto",
                       "email"=>$row[3]];
        array_push($restaurants,$restaurant);
    }
    return $restaurants;
}
function updateAcquirente($cid, $email, $nome, $cognome, $carta, $via, $civico, $cap, $citofono, $istruzioni, $telefono, $zona)
{
	$update_stmt = "UPDATE Acquirente SET nome='" .$nome. "', cognome='" .$cognome. "',
    carta_credito= '" .$carta. "',via='" .$via. "',civico='" .$civico. "', cap='" .$cap. "', citofono='" .$citofono. "',
    istruzioni_consegna='" .$istruzioni. "',telefono='" .$telefono. "', zona= '" .$zona. "' WHERE email='" .$email. "'";
    if ($cid->query($update_stmt) == TRUE)
    {
        echo "Update successful";
    }
    else
    {
        echo "Error: " . $update_stmt . "<br>" . $cid->error;
    }
}
function updateRistorante($cid, $email, $iva, $attività, $zona, $sede, $indirizzo)
{
	$update_stmt = "UPDATE Ristorante
    SET    p_iva='" .$iva. "', r_sociale='" .$attività. "', zona='" .$zona. "', sede_legale='" .$sede. "', ind_completo='" .$indirizzo. "'
     WHERE email='" .$email. "'";
    if ($cid->query($update_stmt) == TRUE)
    {
        echo "Update successful";
    }
    else
    {
        echo "Error: " . $update_stmt . "<br>" . $cid->error;
    }
}
function updateFattorino($cid, $email, $nome, $cognome, $zona)
{
	$update_stmt = "UPDATE Fattorino SET nome='" .$nome. "', cognome='" .$cognome. "',
    zona_operata= '" .$zona. "' WHERE email='" .$email. "'";
    if ($cid->query($update_stmt) == TRUE)
    {
        echo "Update successful";
    }
    else
    {
        echo "Error: " . $update_stmt . "<br>" . $cid->error;
    }
}
function insertOrdine($cid,$acquirente, $ora_ordine)
{
	$insert_stmt = $cid->prepare("INSERT INTO Ordine (acquirente, ora_ordine)
                    VALUES (?,?)");
    $insert_stmt->bind_param('ss', $acquirente, $ora_ordine);
    $insert_stmt->execute();
}

function insertRigaOrdine($cid, $n_riga, $acquirente, $ora_ordine, $ristorante, $nome_prodotto, $prezzo, $qnt)
{
	$insert_stmt = $cid->prepare("INSERT INTO RigaOrdine (n_riga, acquirente, ora_ordine, ristorante, nome_prodotto, prezzo, quantità)
                    VALUES (?,?,?,?,?,?,?)");
    $insert_stmt->bind_param('issssdi', $n_riga, $acquirente, $ora_ordine, $ristorante, $nome_prodotto, $prezzo, $qnt);
    $insert_stmt->execute();
}

function getLineOrderByStatus($cid,$email, $statuses)
{
    $query = "SELECT Ristorante.r_sociale, RigaOrdine.nome_prodotto, RigaOrdine.prezzo, RigaOrdine.quantità, RigaOrdine.ristorante, Ordine.prezzo_tot,RigaOrdine.ora_ordine, Ordine.metodo_pagamento, Ordine.tempistica_consegna, Ordine.stato "   
    .   "FROM RigaOrdine JOIN Ristorante ON RigaOrdine.ristorante = Ristorante.email JOIN Ordine ON Ordine.acquirente=RigaOrdine.acquirente and Ordine.ora_ordine=RigaOrdine.ora_ordine "
    .   "WHERE RigaOrdine.acquirente='".$email."' AND (Ordine.stato = '" . $statuses[0] . "'";
        
    for($i = 1; $i < count($statuses); $i++) {
        $query .= " OR Ordine.stato = '" . $statuses[$i] . "'";
    }
    $query .= ') ';
    $query .= "ORDER BY RigaOrdine.ora_ordine DESC";
    $result = $cid->query($query);
    $RestaurantOrder=[];
    while($row = $result->fetch_row())
    {
        $email_ristorante = $row[4];
        if (!array_key_exists($email_ristorante,$RestaurantOrder)) 
        {
            $RestaurantOrder[$email_ristorante] = [
                'nome'=>$row[0],
                'prezzo_tot'=>$row[5],
                'rigaordine'=>[],
                'quantita_tot'=>0,
                'metodo_pagamento'=>$row[7],
                'tempistica_consegna'=>$row[8],
                "stato" => $row[9]
            ];
        
        }
        $rigaordine = [
            "nome_prodotto" => $row[1],
            "prezzo" => $row[2],
            "quantità" => $row[3],
            "ristorante" => $row[4],
            "ora_ordine" => $row[6],
        ];
        array_push($RestaurantOrder[$email_ristorante]['rigaordine'],$rigaordine);
        $RestaurantOrder[$email_ristorante]['quantita_tot'] = $RestaurantOrder[$email_ristorante]['quantita_tot'] + $row[3];
        $prezzo_tot = $RestaurantOrder[$email_ristorante]['prezzo_tot'];
        $metodo_pagamento = $RestaurantOrder[$email_ristorante]['metodo_pagamento'];
        $tempistica_consegna = $RestaurantOrder[$email_ristorante]['tempistica_consegna'];
        $stato = $RestaurantOrder[$email_ristorante]['stato'];
    }
    return $RestaurantOrder;
}

function deleteProdotto($cid,$email,$nome)
{
    $delete_stmt = "DELETE FROM Prodotto WHERE ristorante='".$email. "' "
                .  "AND nome='" .$nome. "'";
    if ($cid->query($delete_stmt) == TRUE)
    {
        echo "Delete  successful";
    }
    else
    {
        echo "Error: " . $delete_stmt . "<br>" . $cid->error;
    }
}

function payment($cid,$email,$ora_ordine,$stato,$metodo_pagamento)
{
	$update_stmt = "UPDATE Ordine SET stato='In attesa di accettazione', "
    ."metodo_pagamento='".$metodo_pagamento."' "
    ."WHERE acquirente='" .$email. "' "
    ."AND ora_ordine='" .$ora_ordine. "' ";
    if ($cid->query($update_stmt) == TRUE)
    {
        echo "Order successful";
    }
    else
    {
        echo "Error: " . $update_stmt . "<br>" . $cid->error;
    }
}

function getRiderZone($cid,$email)
{
    $result = $cid->query("SELECT zona_operata FROM Fattorino WHERE email = '".$email."'");
    $row = $result->fetch_row();
    $zona = $row[0];
    return $zona;
}

function getPendingOrdersByZone($cid,$zona)
{
    $result = $cid->query(
        "SELECT DISTINCT Ordine.acquirente, Ordine.ora_ordine, stato, metodo_pagamento, prezzo_tot, Ristorante.r_sociale, Ristorante.ind_completo, Acquirente.via, Acquirente.civico, Acquirente.citofono, Acquirente.istruzioni_consegna
        FROM Ordine 
        JOIN Acquirente ON Acquirente.email = Ordine.acquirente 
        JOIN RigaOrdine ON Acquirente.email = RigaOrdine.acquirente
        JOIN Prodotto ON RigaOrdine.nome_prodotto = Prodotto.nome
        JOIN Ristorante ON Prodotto.ristorante = Ristorante.email
        WHERE stato = 'In attesa di accettazione'
        AND Acquirente.zona = '".$zona."'
        ORDER BY Ordine.ora_ordine DESC "
        );
    $orders = [];
    while($row = $result->fetch_row())
    {
        $order = [
            "acquirente" => $row[0],
            "ora_ordine" => $row[1],
            "stato" => $row[2],
            "metodo_pagamento" => $row[3],
            "prezzo_tot" => $row[4],
            "ristorante" => $row[5],
            "indirizzo_ristorante" => $row[6],
            "via_acquirente" => $row[7],
            "civico_acquirente" => $row[8],
            "citofono" => $row[9],
            "istruzioni_consegna" => $row[10]
        ];
        array_push($orders,$order);
    }
    return $orders;
}

function acceptOrder($cid,$email,$acquirente,$ora_ordine,$current_time,$tempistica_consegna)
{
    $update_stmt = "UPDATE Ordine SET fattorino='" . $email . "', stato='In attesa di conferma',
        ora_accettazione='" . $current_time . "', tempistica_consegna='" . $tempistica_consegna . "'
        WHERE acquirente='" . $acquirente . "' AND ora_ordine='" . $ora_ordine . "' ";
    if ($cid->query($update_stmt) == true)  {
        echo "Order accepted";
    }
    else    {
        echo "Error: " . $update_stmt . "<br>" . $cid->error;
    }
}

function getConfirmedOrders($cid, $email)
{
    $result = $cid->query(
        "SELECT DISTINCT Ordine.acquirente, Ordine.ora_ordine, stato, metodo_pagamento, prezzo_tot, Ristorante.r_sociale,
        Ristorante.ind_completo, Acquirente.via, Acquirente.civico, Acquirente.citofono, Acquirente.istruzioni_consegna, Ordine.tempistica_consegna 
        FROM Ordine
        JOIN Acquirente ON Acquirente.email = Ordine.acquirente 
        JOIN RigaOrdine ON Acquirente.email = RigaOrdine.acquirente
        JOIN Prodotto ON RigaOrdine.nome_prodotto = Prodotto.nome
        JOIN Ristorante ON Prodotto.ristorante = Ristorante.email
        WHERE stato = 'In consegna' AND Ordine.fattorino = '".$email."'"
    );
    $orders = [];
    while($row = $result->fetch_row())
    {
        $order = [
            "acquirente" => $row[0],
            "ora_ordine" => $row[1],
            "stato" => $row[2],
            "metodo_pagamento" => $row[3],
            "prezzo_tot" => $row[4],
            "ristorante" => $row[5],
            "indirizzo_ristorante" => $row[6],
            "via_acquirente" => $row[7],
            "civico_acquirente" => $row[8],
            "citofono" => $row[9],
            "istruzioni_consegna" => $row[10],
            "tempistica_consegna" => $row[11]
        ];
        array_push($orders,$order);
    }
    return $orders;
}

function getDisponibility($cid, $email)
{
    $result = $cid->query("SELECT giorno,orario FROM Disponibilità WHERE fattorino='".$email."' ");
    $disponibilità = [];
    while($row = $result->fetch_row())
    {
        $slot = [
            "giorno" => $row[0],
            "orario" => $row[1],
        ];
        array_push($disponibilità,$slot);
    }
    return $disponibilità;
}

function checkDisponibility($cid,$email,$day,$slot)
{
    $result = $cid->query("SELECT * FROM Disponibilità WHERE fattorino='".$email."' AND giorno='".$day."' AND orario='".$slot."' ");
    $num_rows = mysqli_num_rows($result);
    return $num_rows;
}

function addDisponibility($cid,$email,$day,$slot)
{
    $insert_stmt = $cid->prepare("INSERT INTO Disponibilità (fattorino, giorno, orario)
                    VALUES (?,?,?)");
    $insert_stmt->bind_param('sss', $email,$day,$slot);
    $insert_stmt->execute();
}

function removeDisponibility($cid,$email,$day,$slot)
{
    $insert_stmt = $cid->prepare("DELETE FROM Disponibilità WHERE fattorino='".$email."' AND giorno='".$day."' AND orario='".$slot."' ");
    $insert_stmt->execute();
}

function getAvailability($cid, $email)
{
    $result = $cid->query("SELECT giorno,orario FROM Apertura WHERE ristorante='".$email."' ");
    $apertura = [];
    while($row = $result->fetch_row())
    {
        $slot = [
            "giorno" => $row[0],
            "orario" => $row[1],
        ];
        array_push($apertura,$slot);
    }
    return $apertura;
}

function checkAvailability($cid,$email,$day,$slot)
{
    $result = $cid->query("SELECT * FROM Apertura WHERE ristorante='".$email."' AND giorno='".$day."' AND orario='".$slot."' ");
    $num_rows = mysqli_num_rows($result);
    return $num_rows;
}

function addAvailability($cid,$email,$day,$slot)
{
    $insert_stmt = $cid->prepare("INSERT INTO Apertura (ristorante, giorno, orario)
                    VALUES (?,?,?)");
    $insert_stmt->bind_param('sss', $email,$day,$slot);
    $insert_stmt->execute();
}

function removeAvailability($cid,$email,$day,$slot)
{
    $insert_stmt = $cid->prepare("DELETE FROM Apertura WHERE ristorante='".$email."' AND giorno='".$day."' AND orario='".$slot."' ");
    $insert_stmt->execute();
}

function getOrderStateByRider($cid,$email)
{
    $result = $cid->query("SELECT stato FROM Ordine WHERE fattorino='".$email."' ORDER BY ora_accettazione DESC");
    if (!$result) {
        return "Error: " . $cid->error;
    }
    if (mysqli_num_rows($result) == 0) {
        return "No order found";
    } else {
        $row = mysqli_fetch_assoc($result);
        return $row["stato"];
    }
}

function getPastOrdersByRider($cid,$email)
{
    $result = $cid->query(
        "SELECT DISTINCT Ordine.acquirente, Ordine.ora_ordine, Ordine.tempistica_consegna,
        stato, metodo_pagamento, prezzo_tot, Ristorante.r_sociale,
        Ristorante.ind_completo, Acquirente.via, Acquirente.civico 
        FROM Ordine
        JOIN Acquirente ON Acquirente.email = Ordine.acquirente
        JOIN RigaOrdine ON Acquirente.email = RigaOrdine.acquirente
        JOIN Prodotto ON RigaOrdine.nome_prodotto = Prodotto.nome
        JOIN Ristorante ON Prodotto.ristorante = Ristorante.email
        WHERE Ordine.fattorino = '".$email."' 
        AND (stato = 'Consegnato' OR stato = 'Annullato') "
    );
    $pastOrders = [];
    while($row = $result->fetch_row())
    {
        $pastOrder = [
            "acquirente" => $row[0],
            "ora_ordine" => $row[1],
            "tempistica_consegna" => $row[2],
            "stato" => $row[3],
            "metodo_pagamento" => $row[4],
            "prezzo_tot" => $row[5],
            "ristorante" => $row[6],
            "indirizzo_ristorante" => $row[7],
            "via_acquirente" => $row[8],
            "civico_acquirente" => $row[9]
        ];
        array_push($pastOrders,$pastOrder);
    }
    return $pastOrders;
}

function deleteOrdine($cid,$email,$ora_ordine)
{
    $delete_stmt = "DELETE FROM Ordine WHERE acquirente='".$email. "' "
                .  "AND ora_ordine='" .$ora_ordine. "'";
    if ($cid->query($delete_stmt) == TRUE)
    {
        echo "Delete  successful";
    }
    else
    {
        echo "Error: " . $delete_stmt . "<br>" . $cid->error;
    }
}

function deleteOpenOrders($cid,$email_acquirente,$email_ristorante)
{
    $delete_stmt = "DELETE Ordine FROM Ordine join RigaOrdine ON Ordine.acquirente=RigaOrdine.acquirente "
                .  "AND RigaOrdine.ora_ordine=Ordine.ora_ordine "
                .  "WHERE RigaOrdine.ristorante='".$email_ristorante."' "
                .  "AND Ordine.acquirente='".$email_acquirente."' "
                . " AND Ordine.stato='In composizione'";
    if ($cid->query($delete_stmt) == TRUE)
    {
        echo "Delete  successful";
    }
    else
    {
        echo "Error: " . $delete_stmt . "<br>" . $cid->error;
    }
}

function confirmOrders($cid,$email,$ora_ordine)
{
    $update_stmt = "UPDATE Ordine SET stato='In consegna' "
    ."WHERE acquirente='" .$email. "' "
    ."AND ora_ordine='" .$ora_ordine. "' ";
    if ($cid->query($update_stmt) == TRUE)
    {
        echo "Order successful";
    }
    else
    {
        echo "Error: " . $update_stmt . "<br>" . $cid->error;
    }
}

function abortOrders($cid,$email,$ora_ordine)
{
    $update_stmt = "UPDATE Ordine SET stato='Annullato' "
    ."WHERE acquirente='" .$email. "' "
    ."AND ora_ordine='" .$ora_ordine. "' ";
    if ($cid->query($update_stmt) == TRUE)
    {
        echo "Order aborted successful";
    }
    else
    {
        echo "Error: " . $update_stmt . "<br>" . $cid->error;
    }
}

function addProductToMenu($cid,$email,$product,$menu)
{
    $insert_stmt = $cid->prepare("INSERT INTO Compone
                    VALUES (?,?,?,?)");
    $insert_stmt->bind_param('ssss', $product,$email,$menu,$email);
    $insert_stmt->execute();
}

function getAcceptedOrders($cid, $email)
{
    $result = $cid->query(
        "SELECT Ordine.acquirente, Ordine.ora_ordine 
        FROM Ordine
        WHERE stato = 'In attesa di conferma' OR stato = 'In consegna'
        AND Ordine.fattorino = '".$email."'"
    );
    $orders = [];
    while($row = $result->fetch_row())
    {
        $order = [
            "acquirente" => $row[0],
            "ora_ordine" => $row[1]
        ];
        array_push($orders,$order);
    }
    return $orders;
}

function getDataRider($cid,$email)
{
    $select_stmt = $cid->prepare("SELECT * FROM Fattorino WHERE email = ? ");
    $select_stmt->bind_param('s',$email);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    return $result;
}

function getDataBuyer($cid,$email)
{
    $select_stmt = $cid->prepare("SELECT * FROM Acquirente WHERE email = ? ");
    $select_stmt->bind_param('s',$email);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    return $result;
}

function getDataRestaurant($cid,$email)
{
    $select_stmt = $cid->prepare("SELECT * FROM Ristorante WHERE email = ? ");
    $select_stmt->bind_param('s',$email);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    return $result;
}

function getLastOrdersByRider($cid,$email)
{
    $current_day = date("Y-m-d");
    $current_time = date('H:i:s');
    $current_time = strtotime($current_time);
    $result = $cid->query(
        "SELECT DISTINCT Ordine.acquirente, Ordine.ora_ordine,
        stato, Ristorante.r_sociale, Ordine.fattorino, Ordine.ora_accettazione
        FROM Ordine
        JOIN RigaOrdine ON Ordine.acquirente = RigaOrdine.acquirente AND Ordine.ora_ordine = RigaOrdine.ora_ordine
        JOIN Prodotto ON RigaOrdine.nome_prodotto = Prodotto.nome AND RigaOrdine.ristorante = Prodotto.ristorante
        JOIN Ristorante ON Prodotto.ristorante = Ristorante.email
        WHERE Ordine.fattorino <> '" .$email. "'
        AND (stato = 'Consegnato' OR stato = 'Annullato' OR stato = 'In consegna')
        ORDER BY Ordine.ora_ordine DESC"
    );
    $lastOrders = [];
    while($row = $result->fetch_row())
    {
        $lastOrder = [
            "acquirente" => $row[0],
            "ora_ordine" => $row[1],
            "stato" => $row[2],
            "ristorante" => $row[3],
            "fattorino" => $row[4],
            "ora_accettazione" => $row[5]
        ];
        $dt = new DateTime($lastOrder["ora_ordine"]);
        $order_day = $dt->format('Y-m-d');
        if (($current_time - strtotime($lastOrder["ora_accettazione"]) <= 7199) && ($order_day == $current_day))
            array_push($lastOrders,$lastOrder);
    }
    return $lastOrders;
}

function getNameRestaurant($cid,$email_ristorante)
{ 
    $result = $cid->query("SELECT r_sociale FROM Ristorante WHERE email = '".$email_ristorante."'");
    $rows = $result->fetch_row();
    $r_sociale = $rows[0];
    return $r_sociale;
}

function getProductsByRestaurant($cid,$email_ristorante)
{ 
$result = $cid->query("SELECT nome, tipo, descrizione, prezzo, immagine FROM Prodotto WHERE Prodotto.ristorante = '".$email_ristorante."'");
return $result;
}

function deliveredOrders($cid,$email,$ora_ordine)
{
    $update_stmt = "UPDATE Ordine SET stato='Consegnato' "
    ."WHERE acquirente='" .$email. "' "
    ."AND ora_ordine='" .$ora_ordine. "' ";
    if ($cid->query($update_stmt) == TRUE)
    {
        echo "Order delivered successful";
    }
    else
    {
        echo "Error: " . $update_stmt . "<br>" . $cid->error;
    }

}

?>