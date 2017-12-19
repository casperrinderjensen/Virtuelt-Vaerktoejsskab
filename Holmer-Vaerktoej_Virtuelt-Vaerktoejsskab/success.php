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
<link href="styles/orderAndSuccess/style_success.css" rel="stylesheet">
	
<title>Din ordre</title>
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
			
			<div class="col-1-1 mobile-col-1-1 back">
				<a href="landingpage.php"><img src="img/arrow-left.svg" alt="Pil til venstre"></a>
				
				<h2>TAK FOR DIN ORDRE!</h2>
			</div> 
			
		</div>
		
		
		<?php

		//Forbindelse til database
		require_once('db_con.php');


		//Henter order_id fra vores session, som jeg oprettede i cart.php
		$order_id = $_SESSION['order_id'];

		//Selecter valgte ordrer informationer som skal vises til kunden
		$sql = 'SELECT product.id, product.name, product.price, orderItems.order_id, orderItems.product_id, orderItems.quantity 
				FROM orderItems, product 
				WHERE product.id = orderItems.product_id AND '.$order_id.' = orderItems.order_id';

		$stmt = $con->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($pid, $name, $price, $oioid, $oipid, $quantity);
		
		?>
		
		<div class="col-1-1 mobile-col-1-1 header">
			
			<div class="col-1-2 mobile-col-1-2">
				<h2>DIN ORDRE</h2>
			</div>
			
			<div class="col-1-2 mobile-col-1-2">
				<h2>Ordernummer: <?php echo $order_id ?></h2>
			</div>
			
		</div>
		
		
	
		
		<!-- HERUNDER ORDRER INFORMATIONER -->	
		
		<div class="success">
			
			<table class="tableheaders">
			
				<tr>

					<th class="tablehead1">Produkt</th>

					<th class="tablehead2">Pris</th>

					<th class="tablehead3">Antal</th>

				</tr>
		
			</table>

	<?php

	while ($stmt->fetch()){
		
		
			echo '<table class="items" width="100%">';
				
			echo '<tr>';
		
			echo '<td colspan="8" class="name"><p>' . $name . '</p></td>';
		
			echo '<td colspan="6" class="price"><p>' . $price . ' DKK</p></td>';
				
			echo '<td colspan="6" class="quantity"><p>'. $quantity .'</p></td>';
				
			echo '</tr>';
				
			echo '</table>';
				

	};
	?>


		
		


	<!-- Herunder bliver den totale sum udregnet -->	

	<?php 

	// Ganger antallet af produkter med pris
	$sql = 'SELECT sum(orderItems.quantity * product.price)
			FROM orderItems, product WHERE product.id = orderItems.product_id AND '.$order_id.' = orderItems.order_id';
	$stmt = $con->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($total);

	while ($stmt->fetch()){
		echo '<div class="sum">';
		echo '<p>Total: ';
		echo '<b>' . $total . '</b>';
		echo ' DKK</p>';
		echo '</div>';
	};
	?>
		
	
	
			
	<a href="landingpage.php">
		<button class="shop_btn">Tilbage til shop</button>
	</a>
	</div>
		
	
		
	</div>
		
	
	
	
	
	<?php
	}
	?>
	
	</body>
</html>
		
		