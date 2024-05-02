<!DOCTYPE html>
<?php

require "../common/functions.php";

session_start();
$email = $_SESSION["user"];

if (empty($email))
    header("Location: login.php");

?>
<html>

<head>
    <title>Products</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/x-icon" href="../assets/waiter.ico" />
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
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
                        <li><a class="dropdown-item" href="../backend/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="background">
        <div class="container form" style="float:left; width:50%; margin-top:5%;">
            <form method="GET" action="../backend/addMenu.php">
                <h4>
                    <?= htmlentities("Create new menù") ?>
                </h4>
                <?php
                $query = "SELECT nome,immagine FROM Prodotto WHERE ristorante='" . $email . "' AND tipo='Piatto' ";
                $result = mysqli_query($cid, $query);
                $max_num_inserted = 0;
                $i = 0;
                while ($row = $result->fetch_row()) {
                    $product = [
                        "name" => $row[0],
                        "img" => $row[1]
                    ];
                    ?>
                    <div class="col-md-6">
                        <img src="data:image/jpg;base64,<?= base64_encode($product["img"]) ?>" class="card-img-top"
                            style="width:100px; height:100px;" alt="..."></img>
                        <label><input type="checkbox" name="<?= $i ?>" value="<?= $product["name"] ?>">add <?= $product["name"] ?></label><br>
                    </div>
                    <?php
                    $max_num_inserted++;
                    $i++;
                }
                ?>
                <br>
                <input type="hidden" name="num_products" value="<?= $max_num_inserted ?>">
                <input type="text" name="menu_name" placeholder="Insert a menù name"><br>
                <input type="text" name="menu_description" placeholder="Insert a menù description"><br>
                <label>€<input type="number" id="menu_price" name="menu_price"
                        placeholder="Insert a price"></label><br>
                <label>Insert an image (optional) <input type="file" id="image" name="image"></label>
                <input class="btn btn-primary" type="submit" value="ADD">
                <err><?= checkErrorInput() ?></err>
            </form>
        </div>
        <div class="container menues" style="background-color: #ffc107c0; float:right; width:40%; margin-top:5%; margin-right: 7%;">
            <h4>Your menus</h4>
            <?php
            $query1 = "SELECT nome,immagine FROM Prodotto WHERE ristorante='" . $email . "' AND tipo='Menù' ";
            $result1 = mysqli_query($cid, $query1);
            while ($row = $result1->fetch_row()) {
                $menu = [
                    "name" => $row[0],
                    "img" => $row[1]
                ];
                ?>
                <div class="container menu" style="border:2px solid green; display: flex;">
                    <h3><?= $menu["name"] ?></h3>
                    <img src="data:image/jpg;base64,<?= base64_encode($menu["img"]) ?>" class="card-img-top"
                        style="width:100px; height:100px;" alt="..."></img>
                    <?php
                    $query2 = "SELECT piatto FROM Compone WHERE piatto_ristorante='" . $email . "' AND menù_ristorante='" . $email . "' AND menù='" . $menu["name"] . "' ";
                    $result2 = mysqli_query($cid, $query2);
                    ?>
                    <ul>
                    <?php
                    while ($row = $result2->fetch_row()) {
                        ?>
                        <li><?= $row[0] ?>  </li>
                        <?php
                    }
                    ?>
                    </ul>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
function checkErrorInput()
{
    if (isset($_GET["error"]) && $_GET["error"] == "input") {
        echo "Fill all the mandatory fields";
    } else if (isset($_GET["error"]) && $_GET["error"] == "products") {
        echo "Insert at least one product";
    } else {
        echo "";
    }
}

?>