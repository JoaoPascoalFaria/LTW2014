<?php session_start(); 
	if (isset($_SESSION['poolsT_array']) and isset($_SESSION['id_array']) and isset($_SESSION['owner_array'])){
		?>
		<!-- HTML -->	<p>User: <?php echo $_SESSION['id']; ?></p>
		<?php
		var_dump(count($_SESSION['poolsT_array']));

		for($i = 0; $i < count($_SESSION['poolsT_array']); $i++) {
			echo "<br>", $_SESSION['id_array'][$i], $_SESSION['poolsT_array'][$i],$_SESSION['owner_array'][$i],[$i]; ?><br>
		<?php
		}

		/*
			$_SESSION['poolsT_array']=$pools_array;
			$_SESSION['id_array']=$id_array;
			$_SESSION['owner_array']=$owner_array;
		
		*/
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