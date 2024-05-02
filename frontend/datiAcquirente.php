<?php

require "../common/functions.php";

?>

<!DOCTYPE html>
<html>

<head>
    <title>Buyer registration</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../assets/Logo_1mini.png" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.html">
                <img src="../assets/Logo_1.png" width="50%"></img>
            </a>
        </div>
    </nav>
    <br>
    <div class="background">
        <div class="container" style="display:flex;width:100%;">
            <form method="POST" action="../backend/checkDatiAcquirente.php">
                <?php
                if (isset($_GET["status"]) && $_GET["status"] == 'ko')
                    echo "<err>Data contain error(s)</err>";
                ?>
                <div style="width:100%;" align="left">
                    <td>Email: </td>
                    <td><input name="email" placeholder="Insert email address" autofocus></input></td>
                    <?php visualizzaErrore("email"); ?>
                </div>
                <div style="width:100%;" align="left">
                    <td>Password: </td>
                    <td><input type="password" name="pwd" placeholder="Insert password"></input></td>
                    <?php visualizzaErrore("password"); ?>
                </div>
                <div style="width:50%;" align="left">
                    <td>Name: </td>
                    <td><input type="text" name="nome" placeholder="Insert first name"></input></td>
                    <?php visualizzaErrore("nome"); ?>
                </div>
                <div style="width:50%;" align="left">
                    <td>Surname: </td>
                    <td><input type="text" name="cognome" placeholder="Insert surname"></input></td>
                    <?php visualizzaErrore("cognome"); ?>
                </div>
                <div style="width:50%;margin-left:0%;" align="left">
                    <td>Phone: </td>
                    <td><input type="tel" name="telefono" placeholder="Insert phone number"></input></td>
                    <?php visualizzaErrore("telefono"); ?>
                </div>
                <div style="width:50%;" align="left">
                    <td>Zone: </td>
                    <td><input type="number" name="zona" list="numZona" placeholder="Insert zone number">
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
                                </input>
                    </td>
                </div>
                <div style="width:100%;" align="left">
                    <td>Credit card: </td>
                    <td><input type="number" name="cartaCredito" placeholder="0000000000000000"></input></td>
                    <?php visualizzaErrore("carta"); ?>
                </div>
                <div style="width:50%;" align="left">
                    <td>Street: </td>
                    <td><input type="text" name="via" placeholder="Insert street"></input></td>
                    <?php visualizzaErrore("indirizzo"); ?>
                </div>
                <div style="width:50%;" align="left">
                    <td>House number: </td>
                    <td><input name="civico" placeholder="Insert number"></input></td>
                    <?php visualizzaErrore("indirizzo"); ?>
                </div>
                <div style="width:50%;" align="left">
                    <td>Zip code: </td>
                    <td><input type="number" name="cap" placeholder="Insert CAP"></input></td>
                    <?php visualizzaErrore("indirizzo"); ?>
                </div>
                <div style="width:50%;" align="left">
                    <td>Intercom: </td>
                    <td><input type="text" name="citofono" placeholder="Insert intercom"></input></td>
                    <?php visualizzaErrore("citofono"); ?>
                </div>
                <div style="width:100%;" align="left">
                    <td>Delivery instructions: </td>
                    <td><input type="text" name="istruzioniConsegna"
                            placeholder="Insert delivery instructions (optional)"></input></td>
                </div>
                <div class="container" style="display:flex;width:50%;"><input type="submit" value="OK" /></div>
                <div class="container" style="display:flex;width:50%;"><input type="reset" value="Delete" /></div>
        </div>
        </form>
    </div>
</body>

</html>