<?php include('/Includes/mainIncludes.php'); ?>

<?php

if (!isset($_GET['ajax'])) { 
	include('/includes/headerStart.php');
	include('/includes/Header.php');
	include('/includes/NavBar.php');
}
else {
	session_start();
}
if (isset($_GET['shirtID'])) {
	$shirt = filter_input(INPUT_GET,"shirtID",FILTER_SANITIZE_STRING);
	$Shirt = Shirt::ShirtSearch($shirt);
}

if(isset($_SESSION['myuser'])) {
	$user = $_SESSION['myuser']; 
}

if (isset($_GET['addtocart'])) {
	$userID = $_GET['user'];
	$shirtQuant =  $_GET['quant'];
	$shirtID =  $_GET['shirt'];
	Cart::AddShirt($userID, $shirtID, $shirtQuant);
}

?>
<div class="content">
	<h1>Shirt Review</h1>
	<div class="shirt-container">
		<div class="shirt-info">
		<?php echo "<p>$Shirt->Description</p>";?>
		<?php echo "<p>$Shirt->Color</p>";?>
		<?php echo "<p>$Shirt->Brand</p>";?>
		<?php echo "<p>$Shirt->Price</p>";?>
		</div>
		<?php echo "<div class='shirt-image'><img src='$Shirt->Image' alt='$Shirt->Description' /></div>";?>
		<?php
		echo "<p><input type='number' name='shirt$Shirt->ID' id='shirt$Shirt->ID' value='1' />";
		if(isset($_SESSION['myuser'])) {
			$user = $_SESSION['myuser']; 
			
			echo "<a href='#' onclick=\"AjaxCall('shirt','ajax=1&addtocart=1&user=$user->ID&shirt=$Shirt->ID&quant='+shirt$Shirt->ID.value, 'shirts-container');\" >Add To Cart</a></p>";
		}
		else
			echo "<a href='/login.php' >Add To Cart</a></p>";
		?>
	</div>
</div>


<?php include ('/includes/Footer.php'); ?>
</body>
</html>
