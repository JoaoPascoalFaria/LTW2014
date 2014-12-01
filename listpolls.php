<?php session_start(); 
	if (isset($_SESSION['ownpolls']) and isset($_SESSION['ownpollsIds']) ){
		?>
		<!-- HTML -->	<p>User: <?php echo $_SESSION['id']; ?></p>
		<?php
		for($i = 0; $i < count($_SESSION['ownpolls']); $i++) {
			echo "<br>",$_SESSION['ownpollsIds'][$i],$_SESSION['ownpolls'][$i]; ?><br>
		<?php
		}
	}
	else {
				?>
			<form action="controller.php?method=retrieve_all_owner_polls" method="post" >
			<input type="submit" value="Retrive owner polls">
		</form>
		
		<?php


		
	}
?>

<input type="button" onclick="window.location = 'login.php';" value="Return"/>