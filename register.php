<?php session_start();
include("config.php");

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
?>


<form id="register" action="controller.php?method=register" method="post">
	UserName: <input type="text" name="name"><br/>
	Password: <input type="password" name="pw"><br/>
	<input type="submit"/>
</form>