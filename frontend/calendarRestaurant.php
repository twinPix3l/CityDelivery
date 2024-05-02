<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

if (empty($email))
    header("Location: login.php");

$availability = getAvailability($cid, $email);

?>

<html>

<head>
    <title>Restaurant's calendar</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" type="image/x-icon" href="../assets/waiter.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="../js/bundlebasket.js"></script>
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
    <div class="background">
        <h1 style="margin-top:10%">Your schedule</h1>
        <div class="row calendar"
            style="display: inline-flex;background-color:#ffc107c0;width: 100%;text-align: center; margin-top:15px;">
            <div class="col-md-6  card-day" style="width:14%; border:2px solid black; padding-right:0px;">
                <h4>Monday</h4>
                <?php
                foreach ($availability as $slot) {
                    if ($slot["giorno"] == "Lunedì" && $slot["orario"] == "Mattina") {
                        ?>
                <div class="text-card">11:30 - 15:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Lunedì" && $slot["orario"] == "Pomeriggio") {
                        ?>
                <div class="text-card">15:30 - 19:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Lunedì" && $slot["orario"] == "Sera") {
                        ?>
                <div class="text-card">19:30 - 23:30</div>
                <?php
                    }
                }
                ?>
            </div>
            <div class="col-md-6  card-day" style="width:14%; border:2px solid black; padding-right:0px;">
                <h4>Tuesday</h4>
                <?php
                foreach ($availability as $slot) {
                    if ($slot["giorno"] == "Martedì" && $slot["orario"] == "Mattina") {
                        ?>
                <div class="text-card">11:30 - 15:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Martedì" && $slot["orario"] == "Pomeriggio") {
                        ?>
                <div class="text-card">15:30 - 19:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Martedì" && $slot["orario"] == "Sera") {
                        ?>
                <div class="text-card">19:30 - 23:30</div>
                <?php
                    }
                }
                ?>
            </div>
            <div class="col-md-6  card-day" style="width:14%; border:2px solid black; padding-right:0px;">
                <h4>Wednesday</h4>
                <?php
                foreach ($availability as $slot) {
                    if ($slot["giorno"] == "Mercoledì" && $slot["orario"] == "Mattina") {
                        ?>
                <div class="text-card">11:30 - 15:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Mercoledì" && $slot["orario"] == "Pomeriggio") {
                        ?>
                <div class="text-card">15:30 - 19:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Mercoledì" && $slot["orario"] == "Sera") {
                        ?>
                <div class="text-card">19:30 - 23:30</div>
                <?php
                    }
                }
                ?>
            </div>
            <div class="col-md-6  card-day" style="width:14%; border:2px solid black; padding-right:0px;">
                <h4>Thursday</h4>
                <?php
                foreach ($availability as $slot) {
                    if ($slot["giorno"] == "Giovedì" && $slot["orario"] == "Mattina") {
                        ?>
                <div class="text-card">11:30 - 15:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Giovedì" && $slot["orario"] == "Pomeriggio") {
                        ?>
                <div class="text-card">15:30 - 19:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Giovedì" && $slot["orario"] == "Sera") {
                        ?>
                <div class="text-card">19:30 - 23:30</div>
                <?php
                    }
                }
                ?>
            </div>
            <div class="col-md-6  card-day" style="width:14%; border:2px solid black; padding-right:0px;">
                <h4>Friday</h4>
                <?php
                foreach ($availability as $slot) {
                    if ($slot["giorno"] == "Venerdì" && $slot["orario"] == "Mattina") {
                        ?>
                <div class="text-card">11:30 - 15:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Venerdì" && $slot["orario"] == "Pomeriggio") {
                        ?>
                <div class="text-card">15:30 - 19:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Venerdì" && $slot["orario"] == "Sera") {
                        ?>
                <div class="text-card">19:30 - 23:30</div>
                <?php
                    }
                }
                ?>
            </div>
            <div class="col-md-6  card-day" style="width:14%; border:2px solid black; padding-right:0px;">
                <h4>Saturday</h4>
                <?php
                foreach ($availability as $slot) {
                    if ($slot["giorno"] == "Sabato" && $slot["orario"] == "Mattina") {
                        ?>
                <div class="text-card">11:30 - 15:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Sabato" && $slot["orario"] == "Pomeriggio") {
                        ?>
                <div class="text-card">15:30 - 19:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Sabato" && $slot["orario"] == "Sera") {
                        ?>
                <div class="text-card">19:30 - 23:30</div>
                <?php
                    }
                }
                ?>
            </div>
            <div class="col-md-6  card-day" style="width:14%; border:2px solid black; padding-right:0px;">
                <h4>Sunday</h4>
                <?php
                foreach ($availability as $slot) {
                    if ($slot["giorno"] == "Domenica" && $slot["orario"] == "Mattina") {
                        ?>
                <div class="text-card">11:30 - 15:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Domenica" && $slot["orario"] == "Pomeriggio") {
                        ?>
                <div class="text-card">15:30 - 19:30</div>
                <?php
                    }
                    if ($slot["giorno"] == "Domenica" && $slot["orario"] == "Sera") {
                        ?>
                <div class="text-card">19:30 - 23:30</div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="form" style="width:40%; display:inline-flex; margin-top:15px">
            <form method="POST" action="../backend/addSlotRestaurant.php">
                <h5>Add slot</h5>
                <div>
                    <input type="text" name="day" list="week" placeholder="Select day">
                    <datalist id="week" class="form card-week">
                        <option value="Monday">
                        <option value="Tuesday">
                        <option value="Wednesday">
                        <option value="Thursday">
                        <option value="Friday">
                        <option value="Saturday">
                        <option value="Sunday">
                    </datalist>
                    </input>
                    <input type="text" name="slot" list="slots" placeholder="Select slot">
                    <datalist id="slots" class="form card-slot">
                        <option value="11:30 - 15:30">
                        <option value="15:30 - 19:30">
                        <option value="19:30 - 23:30">
                    </datalist>
                    </input>
                </div>
                <button class="button btn" type="reset">CLEAR</button>
                <button class="button btn-success" type="submit" onclick="">ADD</button>
            </form>
            <form method="POST" action="../backend/removeSlotRestaurant.php">
                <h5>Remove slot</h5>
                <div>
                    <input type="text" name="day" list="week" placeholder="Select day">
                    <datalist id="week" class="form card-week">
                        <option value="Monday">
                        <option value="Tuesday">
                        <option value="Wednesday">
                        <option value="Thursday">
                        <option value="Friday">
                        <option value="Saturday">
                        <option value="Sunday">
                    </datalist>
                    </input>
                    <input type="text" name="slot" list="slots" placeholder="Select slot">
                    <datalist id="slots" class="form card-slot">
                        <option value="11:30 - 15:30">
                        <option value="15:30 - 19:30">
                        <option value="19:30 - 23:30">
                    </datalist>
                    </input>
                </div>
                <button class="button btn" type="reset">CLEAR</button>
                <button class="button btn-danger" type="submit">REMOVE</button>
            </form>
        </div>
        <div>
            <err>
                <?= checkErrorSlot() ?>
            </err>
        </div>
    </div>

</body>

<html>
<?php
function checkErrorSlot()
{
    if (isset($_GET["error"])) {
        $error = $_GET["error"];
        if (!empty($error)) {
            if ($error == "full")
                echo "Slot already in your calendar";
            if ($error == "empty")
                echo "Slot is not in your calendar";
            if ($error == "input")
                echo "Select a slot";
        }
    } else {
        echo "";
    }
}

?>