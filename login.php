<?php session_start();

	if(isset($_SESSION['username']) and isset($_SESSION['id'])) {
		header("location: teste.php");
	}
	else if(isset($_SESSION['error'])) {
?>
<!-- HTML -->	<div style="color: red;"><?php echo $_SESSION['error']; ?></div>
<?php
	}
	unset($_SESSION['error']);
	unset($_SESSION['success']);
?>


<div id="login">Login
	<form action="controller.php?method=login" method="post">
		<p>Username: <input type="text" name="username"/></p>
		<p>Password: <input type="password" name="pword"/></p>
		<p><input type="submit" value="Submit"/></p>
	</form>
</div>
<div id="registerbt">
	<input type="button" onclick="window.location = 'register.php';" value="Register"/>
</div>