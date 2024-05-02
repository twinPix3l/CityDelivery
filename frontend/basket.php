<?php

require "../common/functions.php";
session_start();
$email = $_SESSION["user"];

if (empty($email))
    header("Location: login.php");

$result = dbConnection();
$RestaurantOrder = getLineOrderByStatus($cid,$email, ['In composizione']);
$validstatus=['In attesa di accettazione','In attesa di conferma','In consegna'];
$OrderToFinish = getLineOrderByStatus($cid,$email, $validstatus);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Payment</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/payment.css">
    <link rel="icon" type="image/x-icon" href="assets/waiter.ico" />
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
        <div class="container">
            <?php
            if(empty($RestaurantOrder)) {
                echo "There's no payment to display";
            } else {
            foreach ($RestaurantOrder as $email_ristorante => $CurrentOrder)
            {
            ?>
            <div class="card mb-3 bg-dark card-ordine position-relative">
                <div class="row g-0">
                    <div class="col">
                        <div class="card-body text-start">
                            <h5 class="card-title text-center">
                                <?=$CurrentOrder['nome']?>
                            </h5>
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th class="text-center">Quantità</th>
                                                    <th class="text-end">Prezzo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $prezzo_tot=$CurrentOrder['prezzo_tot'];   
                                                foreach ($CurrentOrder['rigaordine'] as $rigaordine)
                                                {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?=$rigaordine['nome_prodotto']?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?=$rigaordine['quantità']?>
                                                    </td>
                                                    <td class="text-end">€
                                                        <?=$rigaordine['prezzo']?>
                                                    </td>
                                                </tr>
                                                <?php 
                                                    $ora_ordine=$rigaordine['ora_ordine'];
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-between">
                                            <span style="float:right;">Total price: €<?=$prezzo_tot;?></span>
                                            <br></br>
                                            <div class="text-end">
                                                <a href="../backend/deleteOrder.php?ora_ordine=<?=$ora_ordine?>"
                                                    class="btn btn-danger">Delete
                                                    Order</a>
                                                </button>
                                                <?php $email_ristorante=$rigaordine['ristorante']; ?>
                                                <a href="../frontend/listaProdottiRistorante.php?email_ristorante=<?=$email_ristorante?>"
                                                    class="btn btn-primary">Change Order</a>
                                                </button>
                                            </div>
                                            <div class="right-action">
                                                <div class="dropdown">
                                                    <form action="../backend/updateOrder.php" method="post"
                                                        class="payment-form">
                                                        <label for="Payment">Select Payment Method:</label>
                                                        <input type="hidden" name="ora_ordine"
                                                            value="<?=$ora_ordine?>" />
                                                        <input type="hidden" name="metodo_pagamento" value=""
                                                            id="metodo_pagamento" />
                                                        <select name="metodo_pagamento" id="Payment">
                                                            <option value="Carta di credito">Pay by credit card
                                                            </option>
                                                            <option value="Contanti">Pay in cash</option>
                                                        </select>
                                                        <?php
                                                        if(array_key_exists($email_ristorante,$OrderToFinish)) { ?>
                                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                            title="Wait to end your previous order">
                                                            <button class="btn btn-primary"
                                                                style="pointer-events: none;" type="button"
                                                                disabled>Buy</button>
                                                        </span>
                                                        </button>
                                                        <?php } else { ?>
                                                        <button class="btn btn-primary btn-purchase" type="submit">
                                                            Buy
                                                        </button>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
    }
}
?>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="../js/bundlebasket.js"></script>
</body>

</html>