<?php 
$userHTML="";
if(isset($_SESSION['myuser'])) {
	$user = $_SESSION['myuser']; 
	$userHTML = "<li><a href='/shoppingcart.php'><i class='fa fa-user'></i> ".$user->Name.' '.$user->LastName."</a></li>";
}
?>
<header class="clearfix">
	<div class="container">
		<div class="header-logo">
			<a href="/">
				<i class="fa fa-shopping-cart"></i> Online Store
			</a>
		</div>
		
		<ul class="header-contact">
			<li><a href="/contact.php">Contact Us</a></li>
			<li><a href="/about.php">About</a></li>
			<?php echo $userHTML; ?>
		<ul>
	</div>
</header>
