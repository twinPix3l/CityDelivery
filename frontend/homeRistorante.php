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
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" type="image/x-icon" href="../assets/Logo_1mini.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="../js/scripts.js" async></script>
    <script src="../js/bundlebasket.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="homeRistorante.php">
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
                        <li><a class="dropdown-item" href="calendarRestaurant.php">Schedule</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="seeProfileRistorante.php">My Profile</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="datiProdotto.php">Add new product</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="vissualiceProdotti.php">View/Delete products</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="datiMenu.php">Create menù</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="../backend/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
	</nav>
    <div style="display: flex;">
    <div class="container" style="float:left; width:30%;">
        <h1 style="margin-top:7.5%; background-color: #ffc107c0;">Open</h1>
        <div class="container">
            <div id="inactive-orders">
            </div>
        </div>
    </div>
    <div class="container" style="width:30%;">
        <h1 style="margin-top:7.5%; background-color: #ffc107c0;">Current</h1>
        <div class="container">
            <div id="current-orders">
            </div>
        </div>
    </div>
    <div class="container" style="float:right; width:30%;">
        <h1 style="margin-top:7.5%; background-color: #ffc107c0;">Closed</h1>
        <div class="container" style="width:100%;">
            <div id="closed-orders">
            </div>
        </div>
    </div>
    </div>
</body>

</html>