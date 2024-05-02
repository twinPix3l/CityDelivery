<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

if (empty($email))
    header("Location: login.php");

?>
<html>

<head>
    <title>Rider's history</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" type="image/x-icon" href="../assets/waiter.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/bundlebasket.js"></script>
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
    <div class="container" style="float:left; width:45%;">
        <h1 style="margin-top:7.5%; background-color: #ffc107c0;">Your past orders:</h1>
        <div class="container" style="width:100%;">
            <div id="past-orders" style="text-align:left; display: flex;">
            </div>
        </div>
    </div>
    <div class="container" style="position: absolute;">
        <div class="loader"></div>
    </div>
    <div class="container" style="float:right; width:45%;">
        <h1 style="margin-top:7.5%; background-color: #ffc107c0;">Last orders:</h1>
        <div class="container" style="width:100%;">
            <div id="last-orders" style="text-align:left; display: flex;">
            </div>
        </div>
    </div>
</body>

</html>