<?php session_start();
ob_start();
include('config.php');

if(isset($_SESSION['username'])) {
	echo 'welcome '.$_SESSION['username'];
?>
<form action="logout.php" method="get">
	<button name="logout" type="submit" >Logout</button>
</form>
<div id="createpollbt">
	<input type="button" onclick="window.location = 'createpoll.php';" value="Create Poll"/>
</div>
<div id="showpollbt">
	<input type="button" onclick="window.location = 'showpoll.php';" value="Show Poll"/>
</div>
<div id="listpolls">
	<input type="button" onclick="window.location = 'listpolls.php';" value="List Polls"/>
	</div>


<?php
}
else {
	header("Location: login.php");
}
?>