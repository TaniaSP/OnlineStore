<?php 
$loginHTML = $logoutHTML =  "";
# Get the number of items in shopping cart, if empty then print nothing
function getShoppingCart(){

	$cartItemsCount = "";
	if(isset($_SESSION['myuser'])) {
		$user = $_SESSION['myuser']; 
		$cartItemsCount = Cart::itemsCount($user->ID);
		if ($cartItemsCount > 0) {
			$cartItemsCount = "(".$cartItemsCount.")";
		}
		
		else {
			$cartItemsCount = "";
		}
	}
	return $cartItemsCount;
}

if(isset($_SESSION['myuser'])) {
	$logoutHTML = "<li><a href='/logout.php'>Log Out</a></li>";
}
else {
	$loginHTML = "<li><a href='/login.php'>Log In</a></li>";
}
?>

<div id="menu">
    <ul class="menu clearfix" >
		<li><a href="/">Home</a></li>
		<li><a href="/buy.php">Buy</a></li>
		<?php echo $loginHTML; ?>
		<?php echo $logoutHTML; ?>
		<li class="lastFloat"><a href="/shoppingcart.php" id="ShoppingCart">Shopping Cart <i class="fa fa-shopping-cart"></i> <span id="shoppingcartCount"><?php echo getShoppingCart(); ?></span></a>
	</ul>
</div>
