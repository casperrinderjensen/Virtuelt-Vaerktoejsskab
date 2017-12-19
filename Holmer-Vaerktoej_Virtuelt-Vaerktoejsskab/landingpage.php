<?php


session_start();// Start Session

if (isset($_SESSION['login_user'])){
	$login_session = $_SESSION['login_user']; 
};

if(!isset($_SESSION['login_user'])){
	echo '<div class="fail col-1-1 mobile-vol-1-1">';
		
		echo '<img src="img/kamasa_shop_text.svg" alt="Kamasa Tools - Virtuelt Værktøjsskab">';
		
		echo '<h1>Du skal være logget ind for at se indholdet på denne side</h1>';
		
	echo '</div>';
};
?>



<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
	
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<link href="styles/browserreset.css" rel="stylesheet">
<link href="styles/simplegrid.css" rel="stylesheet">
<link href="styles/landingpage/styles_landingpage.css" rel="stylesheet">	
	
<title>Virtuelt Værktøjsskab</title>
	
</head>

<body>
	
	<?php
	if(empty($_SESSION['login_user'])){
		
		echo '<div class="login_btn col-1-1">';
	
			echo '<a href="index.php"><button>LOG IND</button></a>';
		
		echo '</div>';
	}
	
	else {
	?>
	
	<div class="grid grid-pad">
		<nav class="col-1-1 mobile-col-1-1">
			<div class="col-1-2 mobile-col-1-2 logo">
				<img src="img/kamasa_shop_text.svg" alt="Kamasa Tools - Virtuelt Værktøjsskab">
			</div>
			
			<div class="col-1-2 mobile-col-1-2 navigation">
				<a href="cart.php"><img class="cart" src="img/kurv.svg" alt="Kurv"></a>
			</div>
			<div class="col-1-2 mobile-col-1-2 logout">
				<a href="logout.php"><button class="logout_btn" type="button">LOG UD</button></a>
			</div>
			
		
		</nav>
		
		<div class="col-1-1 mobile-col-1-1 search-container">
			<form action="">
				<input type="text" placeholder="Søg varer" name="search"><button type="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>
		
		<div class="col-1-1 mobile-col-1-1 header">
			<h1>ELLER VÆLG KATEGORI</h1>
		</div>
		
		
		
		
		<!-- HÅNDVÆRKTØJ SEKTION HERUNDER -->
		
		
		
		<a href="haandvaerktoej.php">
			<div class="col-1-1 mobile-col-1-1 category">
				<div class="col-1-3 mobile-col-1-3 hand">
					<img src="img/handTools.svg" alt="Håndværktøj">
				</div>
				
				<div class="col-1-3 mobile-col-1-3 text">
					<h2>HÅNDVÆRKTØJ</h2>
				</div>
				
				<div class="col-1-3 mobile-col-1-3 arrow">
					<img src="img/arrow-right.svg" alt="Pil til højre">
				</div>
			</div>
		</a>
		
		
		
		<!-- EL VÆRKTØJ SEKTION HERUNDER -->
		
		
		
		<a href="el_vaerktoej.php">
			<div class="col-1-1 mobile-col-1-1 category">
				<div class="col-1-3 mobile-col-1-3 el">
					<img src="img/skruemaskine.svg" alt="El værktøj">
				</div>
				
				<div class="col-1-3 mobile-col-1-3 text">
					<h2>EL VÆRKTØJ</h2>
				</div>
				
				<div class="col-1-3 mobile-col-1-3 arrow">
					<img src="img/arrow-right.svg" alt="Pil til højre">
				</div>
			</div>
		</a>
		
		
		
		<!-- TILBEHØR SEKTION HERUNDER -->
		
		
		
		<a href="tilbehoer.php">
			<div class="col-1-1 mobile-col-1-1 category">
				<div class="col-1-3 mobile-col-1-3 screws">
					<img src="img/tilbehør.svg" alt="Tilbehør">
				</div>
				
				<div class="col-1-3 mobile-col-1-3 text">
					<h2>TILBEHØR</h2>
				</div>
				
				<div class="col-1-3 mobile-col-1-3 arrow">
					<img src="img/arrow-right.svg" alt="Pil til højre">
				</div>
			</div>
		</a>
		
		
		
		
		<!-- MALER SEKTION HERUNDER -->
		
		
		<a href="maler.php">
			<div class="col-1-1 mobile-col-1-1 category4">
				<div class="col-1-3 mobile-col-1-3 brush">
					<img src="img/maler.svg" alt="Maler">
				</div>
				
				<div class="col-1-3 mobile-col-1-3 text">
					<h2>MALER</h2>
				</div>
				
				<div class="col-1-3 mobile-col-1-3 arrow">
					<img src="img/arrow-right.svg" alt="Pil til højre">
				</div>
			</div>
		</a>
		
	
		
		
	</div>
	
	
	
	
	<?php
	}
	?>
</body>
</html>