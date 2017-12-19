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
<link href="styles/cart/styles_cart.css" rel="stylesheet">	
	
<title>Din kurv</title>
	
	
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
			
		</div>
		
		<div class="col-1-1 mobile-col-1-1 header">
			
			<div class="col-1-2 mobile-col-1-2 icon">
				<img src="img/kurv-black.svg" alt="Kurv ikon">
			</div>
			
			<div class="col-1-2 mobile-col-1-2">
				<h1>INDKØBSKURV</h1>
			</div>
			
		</div>
		
		
		
		<!-- KURV PRODUKTER HERUNDER -->
		
		
		<div class="col-1-1 mobile-col-1-1 cart-items">
			
			<?php
	
				// Forbindelse til database
			require_once('db_con.php');


		

				// Hvis session "cart" er tom, vil den udføre nedenstående og return false
			if($_SESSION['cart'] == null)
			{
				echo '<div class="empty">';
				echo '<h2>Din indkøbskurv er tom</h2>';
				echo '</div>';
				return FALSE;

			};	
		
			
		
		
		
	
			// Hvis "delete" bliver udført --> skal nedenstående udføres
			//Det valgte id fra Sessionen "cart" vil blive unset/frakoblet/slettet
			if(filter_input(INPUT_GET, 'delete')) {
					unset($_SESSION['cart'][$_GET['id']]);
			};


			//Hvis "update" bliver udført --> vil nedenstående blive udført
			//Det id og quantity der har forbindelse til hinanden vil blive opdateret
			if(filter_input(INPUT_GET, 'update')) {

					$quantity = 'quantity' . $_GET['id'];
					$_SESSION['cart'][$_GET['id']]['quantity'] = $_POST[$quantity];
			};

		
		
		
		
		
			echo '<table class="tableheaders">';
			
			echo '<tr>';
				
			echo '<th class="tablehead1">Antal</th>';
				
			echo '<th class="tablehead2">Pris</th>';
				
			echo '<th class="tablehead3">Produkt</th>';
				
			echo '</tr>';
		
			echo '</table>';
			





			//HERUNDER har jeg kurven med de valgte produkter fra produktsiderne	
			//Sessionen "cart" bliver kørt igennem en foreach løkke, som vil indsætte et produkt for hvert produkt kunden har tilføjet 
			foreach ($_SESSION['cart'] as $val){
				$id = $val['id'];

				$sql = "SELECT name, price FROM product WHERE id='$id'";
				$stmt = $con->prepare($sql);
				$stmt->execute();
				$stmt->bind_result($name, $price);

				while($stmt->fetch());

				echo '<form method="POST" action="cart.php?id='.$id.'&update=yes">';
				
				echo '<table class="items" width="100%">';
				
				echo '<tr>';
				
				echo '<td colspan="6" class="quantity"><input name="quantity' . $id . '" type="number" value="' .$val['quantity'] . '" min="1"/></td>';
				
				//Her udregnes summen af hvert produkt
				$sum_total =  $price * $val['quantity'];
				echo '<td colspan="6" class="price"><p>' . $sum_total . ' DKK</p></td>';
				
				echo '<td colspan="8" class="name"><p>' . $name . '</p></td>';
				
				echo '<td colspan="6"><button class="update_btn" name="update" type="submit" value="update" require>Opdater</button></td>';
				
				echo '<td><a href="cart.php?id='.$id.'&delete=yes"><button class="delete_btn" name="Delete" type="button" value="delete"><img src="img/delete.svg" alt="Delete"></button></a></td>';
				
				echo '</tr>';
				
				echo '</table>';
				
				echo '</form>';
				
				
				

			};	






			// Hvis prisen og antallet er lig med 0 --> Sæt pris og antal lig med 0
			if (empty($price)) $price =''; 
			if (empty($val['quantity'])) $val['quantity'] ='';  


		




			// HERUNDER vil kurv ordren blive bygget alt efter hvad kunden har tilføjet til kurven
			// Hvis "cart_order" udføres --> Udfør nedenstående
			if(filter_input(INPUT_GET, 'cart_order')) {
				
				$sql = 'INSERT INTO 3semFlow5.order (id) VALUES (?)';
				$stmt = $con->prepare($sql);
				$stmt->bind_param('i', $order_id);
				$stmt->execute();
				$order_id = $con->insert_id;
			
				
				
				// Hvis order_id er set --> Udfør nedenstående
				if(isset($order_id)) {

					// Sessionen "cart" bliver kørt igennem en foreach løkke, som indsætter udvalgte informationer i ordren
					foreach($_SESSION['cart'] as $val) {

						$sql = 'INSERT INTO orderItems (order_id, product_id, quantity) VALUES (?,?,?)';
						$stmt = $con->prepare($sql);
						$stmt->bind_param('iii', $order_id, $val['id'], $val['quantity']);
						$stmt->execute();	
					}
					
					
				
					//Herunder redirecter jeg til success.php og kunden vil blive mødt af at ordren er sendt
					echo "<script type=\"text/javascript\"> setTimeout(function () {
							window.location.href= 'success.php';
							}, 0); </script>"; 
					
				
					
					$_SESSION['cart'] = null;
					
					
					
					$_SESSION['order_id'] = $order_id;
				};
				
				if(!isset($order_id)){
					
					echo 'Der skete en fejl. Din ordrer blev ikke sendt, prøv igen';
				};
				
			};
		?>
		
		
		

			
	
			
		<div class="buttons">
			
				<a href="landingpage.php">
					<button class="shop">SHOP VIDERE</button>
				</a>	

				<a href="cart.php?cart_order=yes">
					<button class="order" name="submit" id="indsend" value="indsend">SEND ORDRE</button>
				</a>
		</div>
			

		
		</div>
		
		
	</div>
	
	
	
		
		
		
	
	<?php
	};
	?>
	
	
	
	
	
	
</body>
</html>