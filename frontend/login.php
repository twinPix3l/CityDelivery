<html>

<head>
	<title>Login</title>
	<link rel="icon" type="image/x-icon" href="assets/waiter.ico" />
	<link rel="stylesheet" href="../css/styles.css">

</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="../index.html">
				<img src="../assets/Logo_1.png" width="40%"></img>
			</a>
		</div>
	</nav>
	<br>
	<br>
	<h1 class="titolo" align="center">Servizi riservati</h1>
	<br>
	<h4 class="titolo" align="center">Per accedere digitare username e password, quindi premere OK. </h4>
	<br><br>
	<div class="container" style="display:flex;width:100%;">
		<form method="POST" action="../backend/checkLogin.php">
			<!--<table align="center">-->
			<div style="width:100%;" align="left">
				<td>Email: </td>
				<td><input name="email" placeholder="Insert email address" autofocus required></input></td>
			</div>
			<div style="width:100%;" align="left">
				<td>Password: </td>
				<td><input type="password" name="pwd" placeholder="Insert password" autofocus required></input></td>
			</div>
			<div class="container" style="display:flex;width:50%;"><input type="submit" value="OK" /></div>
			<div class="container" style="display:flex;width:50%;"><input type="reset" value="Cancella" /></div>
			<!--</table>-->
			<err class="errore">
				<?php checkErrorLogin(); ?>
			</err>
		</form>
	</div>
</body>

</html>

<?php

require "../common/functions.php";

session_start();

$parameter = "";

if (isset($_SESSION["user"])) {
	$email = $_SESSION["user"];

	$selectEmail = getDataBuyer($cid, $email);
	$selectEmail = $selectEmail->fetch_row();
	if (mysqli_num_rows($selectEmail) == 1)
		$parameter = "Location: homeAcquirente.php";

	$selectEmail = getDataRestaurant($cid, $email);
	$selectEmail = $selectEmail->fetch_row();
	if (mysqli_num_rows($selectEmail) == 1)
		$parameter = "Location: homeRistorante.php";

	$selectEmail = getDataRider($cid, $email);
	$selectEmail = $selectEmail->fetch_row();
	if (mysqli_num_rows($selectEmail) == 1)
		$parameter = "Location: homeFattorino.php";

	header($parameter);
}

?>

<?php

function checkErrorLogin()
{
	if (isset($_GET["errore"])) {
		if ($_GET["errore"] == "email")
			echo "Email is wrong";
		if ($_GET["errore"] == "password")
			echo "Password is wrong";
	} else
		echo "";
}

?>