<?php


session_start(); // Starter session
$echo = "Brugernavn eller adgangskode var ikke korrekt, prøv igen";

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
	
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

<link href="styles/browserreset.css" rel="stylesheet">
<link href="styles/simplegrid.css" rel="stylesheet">
<link href="styles/login/styles_login.css" rel="stylesheet">
	
<title>Virtuelt Værktøjsskab - Log ind</title>
	
</head>

<body>
	
<div class="grid grid-pad">
	
	<div class="col-1-1 mobile-col-1-1 logo">
		<img src="img/kamasa_shop_text.svg" alt="Kamasa Tools - Virtuelt Værktøjsskab">
	</div>
	
	<div class="form_wrapper">
		<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
			<div class="col-1-1 mobile-col-1-1 username">
				<input type="text" name="username" placeholder="Brugernavn" type="text" required>
			</div>

			<div class="col-1-1 mobile-col-1-1 password">
				<input type="password" name="password" placeholder="Adgangskode" type="password" required>
			</div>

			<div class="col-1-1 mobile-col-1-1 submit">
				<button name="submit" type="submit">LOG IND</button>
			</div>
		</form>
	</div>
	
	
	<p>Er du endnu ikke bruger af det Virtuelle Værktøjsskab? <br><br>
		Så kan du anmode om en bruger på <a href="mailto:kamasa@shop.dk">kamasa@shop.dk</a></p>
	
</div>
	
	
	
<?php
		
		//Hvis "log ind" bliver trykket --> Udfør nedenstående	
	
		if (isset($_POST['submit'])) {
		if (empty($_POST['username']) || empty($_POST['password'])) {
			echo '<h2 style="color: #FF4242">'. $echo .'</h2>';
			}
			else
			{

			// Definere brugernavn og adgangskode
			$username = $_POST['username'];
			$password = $_POST['password'];

			// Forbinder til database
			require_once('db_con.php');

			// Selecter fra database
			$query = 'SELECT username, password from tbl_user where username=? AND password=? LIMIT 1';

			$stmt = $con->prepare($query);
			$stmt->bind_param('ss', $username, $password);
			$stmt->execute();
			$stmt->bind_result($un, $password);
			$stmt->store_result();

			if($stmt->fetch())
					{
					  $_SESSION['login_user'] = $username;
					  echo "<script type=\"text/javascript\"> setTimeout(function () {
										window.location.href= 'landingpage.php';
										}, 0); </script>";
					}
			else {
					echo '<div style="text-align: center;">';
				   	echo '<h2 style="color: #FF4242; padding-left: 15px;padding-right: 15px; padding-top: 30px;">'. $echo .'</h2>';
					echo '</div>';
				 }
			mysqli_close($con); //Lukker forbindelsen
			}
			}
			  
			  
		if(isset($_SESSION['login_user'])){
		echo "<script type=\"text/javascript\"> setTimeout(function () {
								window.location.href= 'landingpage.php';
								}, 0); </script>";
		}
?> 
	
</body>
</html>