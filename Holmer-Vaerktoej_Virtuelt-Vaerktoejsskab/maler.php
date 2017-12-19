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

<link href="styles/browserreset.css" rel="stylesheet">
<link href="styles/simplegrid.css" rel="stylesheet">
<link href="styles/productpage/styles_products.css" rel="stylesheet">
	
<title>Maler</title>
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
				<div class="col-1-2 mobile-col-1-2 logout">
					<a href="logout.php"><button class="logout_btn" type="button">LOG UD</button></a>
				</div>
			</div>
		
		</nav>
		
		<div class="col-1-1 mobile-col-1-1 container">
			
			<div class="col-1-2 mobile-col-1-2 back">
				<a href="landingpage.php"><img src="img/arrow-left.svg" alt="Pil til venstre"></a>
			</div>
			
			<div class="col-1-2 mobile-col-1-2 cart">
				<a href="cart.php"><img src="img/kurv.svg" alt="Din kurv"></a>
			</div>
			
		</div>
		
		<div class="col-1-1 mobile-col-1-1 header">
			
			<div class="col-1-2 mobile-col-1-2 icon">
				<img src="img/maler.svg" alt="Maler ikon">
			</div>
			
			<div class="col-1-2 mobile-col-1-2">
				<h1>MALER</h1>
			</div>
			
		</div>
		
		<div class="col-1-1 mobile-col-1-1 products">
			
			<?php 

			// Forbindelse til database	
			require_once('db_con.php');



			//Henter produkterne fra produkt-tabellen i databasen
			$sql = 'SELECT id, name, image, price FROM product WHERE category = "Maler"';
			$stmt = $con->prepare($sql);
			$stmt->execute();
			$stmt->bind_result($id, $name, $image, $price);

				while($stmt->fetch()){ 
			?>	
			
				
			<table class="col-1-2 mobile-col-1-2">
				<tr>
					<th>
						<img src="images/<?php echo $image; ?>" alt="Produkter">
						<hr>
					</th>
				</tr>
				
				<tr>
					<th class="name"><?php echo '<p>' .$name. '</p>'; ?></th>
				</tr>

				<tr>
					<th class="bottom">
						
						
						<a href="maler.php?id=<?php echo $id; ?>&add=yes">
							<button name="add" type="submit" value="add">LÆG I KURV</button>
						</a>
						
						<?php echo '<p>' .$price. ' DKK</p>'; ?>
						
					</th>
				</tr>	
			</table>



			<?php
			};
			?>
		
		</div>
		
		<?php


		//Hvis "add" bliver udført --> Udfør nedenstående
		// Gør det muligt at tilføje produkter til kurv	
		if(filter_input(INPUT_GET, 'add')) {

			//Henter produkt id fra URL via GET
			$_SESSION['cart'][$_GET['id']]['id'] = $_GET['id'];

			//Tilføjer +1 til quantity hver gang "add" udføres
			if(!isset($_SESSION['cart'][$_GET['id']]['quantity'])) { 
				$_SESSION['cart'][$_GET['id']]['quantity'] = 1;
			} 

			else {
				$_SESSION['cart'][$_GET['id']]['quantity'] += 1;
			}

		};

		?>
		
		
		
		
	</div>
	
	
	
	
	
	
	<?php
	};
	?>
	
	
	
</body>
</html>