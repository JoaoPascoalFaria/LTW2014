<?php session_start();
	require_once('header.php');
	if (isset($_SESSION['poolsT_array']) /*and isset($_SESSION['id_array']) and isset($_SESSION['owner_array'])*/){
		//echo count($_SESSION['poolsT_array']);
		for($i = 0; $i < count($_SESSION['poolsT_array']); $i++) {
			echo "<div class='poll'>";
			echo "<p>", $_SESSION['id_array'][$i], "</p>";
			?>
			<form id="my_form" action="controller.php?method=retrievepoll" method="post">
				<input type="hidden" name="id" value="<?php echo $_SESSION['id_array'][$i]; ?>">
				<a href="#" onclick="$('#my_form').submit();"><?php echo $_SESSION['poolsT_array'][$i]; ?></a>
			</form>
			<?php
			//echo "<p>", $_SESSION['poolsT_array'][$i], "</p>";
			if( isset( $_SESSION['owner_array'])) {
				echo "<p>", $_SESSION['owner_array'][$i], "</p>";
			}
			echo "</div>";
		}
		unset($_SESSION['poolsT_array']);
		unset($_SESSION['id_array']);
		unset($_SESSION['owner_array']);
	}
	else {
		?>
		<form action="controller.php?method=retrieve_all_owner_polls" method="post" >
			<input type="submit" value="Retrive owner polls">
		</form>
		<form action="controller.php?method=retrieve_all_polls" method="post" >
			<input type="submit" value="Retrive all public polls">
		</form>
		<?php		
	}
?>

<input type="button" onclick="window.location = 'login.php';" value="Return"/>