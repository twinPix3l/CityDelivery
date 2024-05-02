<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

if (empty($email))
    header("Location: login.php");

$result = getDataRider($cid, $email);
$rows = $result->fetch_row();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Runner's profile</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="assets/waiter.ico" />
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
                    <h4 class="card-title"><?= $rows[0] ?></h4>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Nome: <?= $rows[2] ?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Cognome: <?= $rows[3] ?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Credito: €<?= $rows[4] ?></h5>
                </div>
                <div style="width:100%;" align="left">
                    <h5 class="card-title">Zona operata: <?= $rows[5] ?></h5>
                </div>
        </div>
        <br>
        <a href="updateFattorino.php" class="btn btn-primary">Update profile</a>

</body>

</html>