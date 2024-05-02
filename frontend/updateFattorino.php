<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

if (empty($email))
    header("Location: login.php");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Update runner</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../assets/Logo_1mini.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="homeFattorino.php">
                <img src="../assets/Logo_1.png" width="40%"></img>
            </a>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                        <span class="align-self-center">
                            <?= $email ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="calendarRider.php">Schedule</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="historyRider.php">History</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="seeProfileFattorino.php">My Profile</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="../backend/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <div class="background">
        <div class="container" style="display:flex;width:100%;">
            <form method="POST" action="../backend/UpdateDatiFattorino.php">
                <?php
                if (isset($_GET["status"]) && $_GET["status"] == 'ko')
                    echo "<err>Data contain error(s)</err>";
                ?>
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

                <div style="width:100%;" align="left">
                    <td>Delivery zone: </td>
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
                <div class="container" style="display:flex;width:50%;"><input type="submit" value="OK" /></div>
                <div class="container" style="display:flex;width:50%;"><input type="reset" value="Delete" /></div>
        </div>
        </form>
    </div>
    <script src="../js/bundlebasket.js"></script>
</body>

</html>