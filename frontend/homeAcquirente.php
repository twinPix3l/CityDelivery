<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

if (empty($email))
	header("Location: login.php");

$zona = getBuyerZone($cid, $email);
$restaurants = getRestaurantsByZone($cid, $zona);

?>

<html>
<!DOCTYPE html>

<head>
    <title>Homepage buyer</title>
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
    <div class="background">
        <h1>Buyer's homepage</h1>
        <h4>Restaurants in zona <?= $zona; ?>:</h4>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <?php
					foreach ($restaurants as $restaurant) {
						?>
                    <div class="card mb-3 bg-dark card-restaurant position-relative">
                        <div class="row g-0">
                            <div class="col">
                                <div class="card-body">
                                    <a href="listaProdottiRistorante.php?email_ristorante=<?= $restaurant["email"] ?>"
                                        class="stretched-link">
                                        <h5 class="card-title">
                                            <?= $restaurant["r_sociale"]; ?>
                                        </h5>
                                    </a>
                                    <p class="card-text"><?= $restaurant["indirizzo"]; ?></p>
                                    <p class="card-text"><small
                                            class="text-<?= $restaurant["stato"] == "Chiuso" ? "danger" : "success" ?>">
                                            <?= $restaurant["stato"] ?>
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
					}
					?>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>

</body>

</html>