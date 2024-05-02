<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

if (empty($email))
    header("Location: login.php");

$cid = $result["value"];
$result = $cid->query("SELECT * FROM Acquirente WHERE email = '".$email."'");
$rows = $result->fetch_row();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Buyer's profile</title>
    <link rel="stylesheet" href="../css/styles.css">
	  <link rel="icon" type="image/x-icon" href="../assets/waiter.ico" />
	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
            <a class="navbar-brand" href="homeAcquirente.php">
                <img src="../assets/Logo_1.png" width="50%"></img>
            </a>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                        <span class="align-self-center"><?= $email ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="basket.php">My Payments</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="checkOrder.php">Check my Order</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="seeProfileAcquirente.php">My Profile</a></li>
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
        <h3>Profile</h3>
        <div class="container" style="display:flex;width:100%;">
            <form>
            <img src="../images/perfil.png" style="width:20%">

                <div style="width:100%;" align="center">
                    <h4 class="card-title"><?=$rows[0]?></h4>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Nome: <?=$rows[2]?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Cognome: <?=$rows[3]?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Carta di credito: <?=$rows[5]?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Via: <?=$rows[6]?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Civico: <?=$rows[7]?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Cap: <?=$rows[8]?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Citofono: <?=$rows[9]?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Instruzioni di consegna: <?=$rows[10]?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Telefono: <?=$rows[11]?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Zona: <?=$rows[12]?></h5>
                </div>
        </div>
        <br>
        <a href="updateAcquirente.php" class="btn btn-primary">Update profile</a>
        <script src="../js/bundlebasket.js"></script>
</body>

</html>