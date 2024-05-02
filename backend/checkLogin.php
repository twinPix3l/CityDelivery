<?php

session_start();

require "../common/db_connection.php";
require "db_config.php";

$result = dbConnection();
$cid = $result["value"];

$parameter = "";

if (isset($_POST["email"]) && isset($_POST["pwd"]) && $result["status"]=="ok")
{
	$email = $_POST["email"];
	$email = trim($email);
	//$mysqli -> real_escape_string($email);

	$password = $_POST["pwd"];

	$selectEmail = mysqli_query($cid, "SELECT * FROM Acquirente WHERE email = /*?*/'".$email."'");

	/*$selectEmail -> bind_param("s", $email);
	$stmt -> execute;*/
	if (mysqli_num_rows($selectEmail) == 1) 
	{
		$selectPwd = mysqli_query($cid, "SELECT * FROM Acquirente WHERE psw = '".$password."' AND email = '".$email."'");
		if (mysqli_num_rows($selectPwd) == 1) 
		{			
			$_SESSION["user"] = $_POST["email"];
			$parameter = "Location: ../frontend/homeAcquirente.php";
			//echo "<html><body><br><br>Welcome back, ",$email,"</body></html>";
		}
		else $parameter = "Location: ../frontend/login.php?errore=password&email=$email";
	}
	else
	{
		$selectEmail = mysqli_query($cid, "SELECT * FROM Ristorante WHERE email = '".$email."'");
		if (mysqli_num_rows($selectEmail) == 1) 
		{
			$selectPwd = mysqli_query($cid, "SELECT * FROM Ristorante WHERE psw = '".$password."' AND email = '".$email."'");
			if (mysqli_num_rows($selectPwd) == 1) 
			{
				$_SESSION["user"] = $_POST["email"];
				$parameter = "Location: ../frontend/homeRistorante.php";
				//echo "<html><body><br><br>Welcome back, ",$email,"</body></html>";
			}
			else $parameter = "Location: ../frontend/login.php?errore=password&email=$email";
		}
		else 
		{
			$selectEmail = mysqli_query($cid, "SELECT * FROM Fattorino WHERE email = '".$email."'");
			if (mysqli_num_rows($selectEmail) == 1) 
			{
				$selectPwd = mysqli_query($cid, "SELECT * FROM Fattorino WHERE psw = '".$password."' AND email = '".$email."'");
				if (mysqli_num_rows($selectPwd) == 1) 
				{
					$_SESSION["user"] = $_POST["email"];
					$parameter = "Location: ../frontend/homeFattorino.php";	
				}
				else $parameter = "Location: ../frontend/login.php?errore=password&email=$email";
			}
			else	$parameter = "Location: ../frontend/login.php?errore=email&email=$email";
		}
	}
	header($parameter);
}
elseif ($result["status"]=="ko")
{
	echo "<html><body><br><err>Failed connection to database. </err></body></html>";
}

?>