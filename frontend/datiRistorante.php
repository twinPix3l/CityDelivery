<?php

include "../common/functions.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Restaurant registration</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../assets/Logo_1mini.png" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.html"">
                <img src="../assets/Logo_1.png" width="50%"></img>
            </a>
        </div>
    </nav>
        <br>
	    <div class="background">
		<div class="container" style="display:flex;width:100%;">
    		<form method="POST" action="../backend/checkDatiRistorante.php">
    		    <div style="width:100%;" align="left">
			        <td>Email: </td><td><input name = "email" placeholder="Insert email address" autofocus></input></td>
                    <?php visualizzaErrore("email"); ?>
    		    </div>
                <div style="width:100%;" align="left">
                    <td>Password: </td><td><input type = "password" name = "pwd" placeholder="Insert password"></input></td>
                    <?php visualizzaErrore("password"); ?>
                </div>
                <form method="GET" action="../backend/checkDatiAcquirente.php">
                    <div style="width:100%;margin-left:0%;" align="left">
                        <td>VAT number: </td><td><input type = "number" name = "p_iva" placeholder="Insert VAT number"></input></td>
                        <?php visualizzaErrore("iva"); ?>
                    </div>
                    <div style="width:100%;margin-left:0%;" align="left">
                        <td>Activity name: </td><td><input type = "text" name = "r_sociale" placeholder="Insert activity name"></input></td>
                        <?php visualizzaErrore("attività"); ?>
                    </div>
                    <div style="width:100%;" align="left">
                        <td>Zone: </td><td><input type = "number" name = "zona" list="numZona" placeholder="Insert zone number">
                        <?php visualizzaErrore("zona"); ?>
                            <datalist id="numZona">
                                <option value="1">
                                <option value="2">
                                <option value="3">
                                <option value="4">
                                <option value="5">
                                <option value="6">
                                <option value="7">
                                <option value="8">
                                <option value="9">
                            </datalyst>
                        </input></td>
                    </div>
                    <div style="width:100%;" align="left">
                        <td>Registered office: </td><td><input type = "address" name = "s_legale" placeholder="Insert registered office address"></input></td>
                        <?php visualizzaErrore("indirizzo"); ?>
                    </div>
                    <div style="width:100%;" align="left">
                        <td>Complete address: </td><td><input type = "address" name = "indirizzo" placeholder="Insert complete address"></input></td>
                        <?php visualizzaErrore("indirizzo"); ?>
                    </div>
                    <div class="container" style="display:flex;width:50%;"><input type= "submit" value= "OK"/></div>
				    <div class="container" style="display:flex;width:50%;"><input type = "reset" value = "Cancella"/></div>
                    <?php
                    if (isset($_GET["status"]) && $_GET["status"] == 'ko') echo "<err>Data contain error(s)</err>";
                    ?>		
                    </div>
                </form>
            </div>
	</body>
    <script src="../js/bundlebasket.js"></script>
</html>