<!-- Log In page: compares user inputs with the database to validate the user --> 
<?php include('/Includes/mainIncludes.php'); ?>
<?php include('/Includes/headerStart.php'); ?>
<?php include('/Includes/Header.php'); ?>
<?php include('/Includes/NavBar.php'); ?>

<div class="content">
	<h1>Log In</h1>
	<form name='login' action='login.php' method='post'>
		<p>Enter as a client with 'john@domain.com' and 'john'</p>
		<p>Enter as a admin with 'tania@domain.com' and 'tania'</p>
		<p>Email: <input name='email' id='email' type='text' value='' /></p>
		<p>Password: <input name='password' name='password' type='password' value='' /></p>
		<p><input type='submit' value='Go' name='btnEntrar' /></p>
		<p><a href="/comingsoon.php">I Forgot My Password</a></p>
	</form>
</div>

<?php
if (isset($_POST['email']))
{
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	try
	{
		if ($password == "" ) {
			throw new Exception();
		}
		
		$user = new User("", "", "", $email, $password, "");
		$user->SearchUserByEmail();
		if ($user->Password == $password)
		{
			$_SESSION['myuser'] = $user;
			header("Location: index.php");
			die();
		}
		else
		{
			echo "<p class='error'>Invalid username</p>";
		}
	}
	catch (Exception $e)
	{
		echo "<p class='error'>Invalid username or password</p>";
	}
}
?>

<?php include ('/includes/Footer.php'); ?>
</body>
</html>
