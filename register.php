<?php session_start();

	if (isset($_SESSION['error'])){
?>
<!-- HTML -->	<div style="color: red;"><?php echo $_SESSION['error']; ?></div>
<?php
	}
	else if(isset($_SESSION['success'])) {
?>
<!-- HTML -->	<div style="color: green;"><?php echo $_SESSION['success']; ?></div> 
<!-- HTML -->	<script type='text/javascript'>setTimeout(function() { window.location = "teste.php"; }, 3000);</script>
<?php
	}
	unset($_SESSION['error']);
	unset($_SESSION['success']);
?>


<form id="register" action="controller.php?method=register" method="post">
	<p>UserName: <input type="text" name="name"></p>
	<p>Password: <input type="password" name="pw"></p>
	<p><input type="submit" value="Submit"/></p>
</form>
<input type="button" onclick="window.location = 'login.php';" value="Return"/>