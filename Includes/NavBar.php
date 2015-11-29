<?php 
$loginHTML = $logoutHTML = $cartItemsCount = "";
if(isset($_SESSION['myuser'])) {
	$user = $_SESSION['myuser']; 
	$cartItemsCount = Cart::itemsCount($user->ID);
	if ($cartItemsCount > 0) {
		$cartItemsCount = "(".$cartItemsCount.")";
	}
	
	else {
		$cartItemsCount = "";
	}
	
	$userHTML = "<li><a href='/shoppingcart.php'>".$user->Name.' '.$user->LastName."</a></li>";
	$logoutHTML = "<li><a href='/logout.php'>Log Out</a></li>";
}
else
{
	$loginHTML = "<li><a href='/login.php'>Log In</a></li>";
}
?>

<div id="menu">
    <ul class="menu clearfix" >
		<li><a href="/">Home</a></li>
		<li><a href="/buy.php">Buy</a></li>
		<?php echo $loginHTML; ?>
		<?php echo $logoutHTML; ?>
		<li class="lastFloat"><a href="/shoppingcart.php" id="ShoppingCart">Shopping Cart <i class="fa fa-shopping-cart"></i> <span class="shoppingcart"><?php echo $cartItemsCount; ?></span></a>
	</ul>
</div>
