<?php 
$userStart = false;
$loginHTML = $logoutHTML = $userHTML="";
if(isset($_SESSION['myuser'])) {
	$user = $_SESSION['myuser']; 
	$userStart = true;
	$userHTML = "<li><a href='/shoppingcart.php'>".$user->Name.' '.$user->LastName."</a></li>";
	$logoutHTML = "<li><a href='/logout.php'>Log Out</a></li>";
}
else
{
	$loginHTML = "<li><a href='/login.php'>Log In</a></li>";
}
?>

<div id="menu">
    <ul class="menu" >
		<li><a href="/">Home</a></li>
		<li><a href="/buy.php">Buy</a></li>
		<?php echo $loginHTML; ?>
		<?php echo $userHTML; ?>
		<?php echo $logoutHTML; ?>
		<li><a href="/shoppingcart.php" id="ShoppingCart">Shopping Cart <i class="fa fa-shopping-cart"></i></a>
	</ul>
</div>
