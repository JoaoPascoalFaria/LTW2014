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


<form id="createpoll" action="controller.php?method=createpoll" method="post">
	<p>Title: <input type="text" name="title"></p>
	<p><input type="checkbox" name="private"> Private</p>
	<p>Question: <input type="text" name="question"></p>
	<p>Answer: <input type="text" name="answer1"></p>
	<p>Answer: <input type="text" name="answer2"></p>
	<p><input type="submit" value="Submit"/></p>
</form>
<input type="button" onclick="window.location = 'login.php';" value="Return"/>