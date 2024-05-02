<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

if (empty($email))
    header("Location: login.php");

$zona = getRiderZone($cid, $email);
$orders = getPendingOrdersByZone($cid, $zona);

?>

<html>

<head>
    <title>Rider's homepage</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" type="image/x-icon" href="../assets/waiter.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/scripts.js" async></script>
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
    <div class="background">
        <div class="container" style="float:left; width:45%; margin-top:3%;">
            <div class="col-md-6 offset-md-3" style="width:75%; margin-right: 15px;">
                <h3 style="background-color: #ffc107c0;">Pending orders in your zone</h3>
                <button class="btn btn-primary update" id="update-button" style="border-radius: 10px;"
                    onclick="updatePendingOrders()"><span class=reload>&#x21bb;</span> get orders</button><br>
                <err style="background-color:#ffc107;"><?= checkErrorInput() ?></err>
                <div id="pending-orders" style="text-align:left">
                </div>
            </div>
        </div>
        <div class="container" style="float:right; width:45%; margin-top:3%;">
            <div class="col-md-6 offset-md-3" style="width:75%; margin-left: 15px;">
                <h3 style="background-color: #ffc107c0;">Confirmed order</h3>
                <button class="btn btn-primary update" id="update-button" style="border-radius: 10px;"
                    onclick="updateConfirmedOrders()"><span class=reload>&#x21bb;</span> get order</button>
                <div id="confirmed-orders" style="text-align:left">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
function checkErrorInput()
{
    if (isset($_GET["error"]) && $_GET["error"] == "input") {
        echo "Select a valid delivery timing";
    } else {
        echo "";
    }
}

?>