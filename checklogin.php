<?php session_start();
ob_start();
include('config.php');

if(isset($_SESSION['username'])){
		echo 'welcome '.$_SESSION['username'];
		echo '<form action="logout.php" method="get">
                 <button name="logout" type="submit" >Logout</button>
                 </form>';
	}
	else {
		header("Location: login.php");
	}

?>