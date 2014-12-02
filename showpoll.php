<?php session_start();
	if (isset($_SESSION['poolsT_array'])){
		?>
		<!-- HTML -->	<p>Title: <?php echo $_SESSION['poolsT_array'][$_SESSION['pollid']]; ?></p>
		<!-- HTML -->	<p id="questions">Questions:<br>
		<?php
		for($i = 0; $i < count($_SESSION['questions']); $i++) {
			echo "<br>",$_SESSION['questions'][$i]; ?><br>
			<p id="answers">Choices:<br>
				<?php
				for($j = 0; $j < count($_SESSION['q'.$i.'answer']); $j++) {
					echo $j+1,": ",$_SESSION['q'.$i.'answer'][$j],"<br>";
				}
				?>
			</p>
			<?php
			unset($_SESSION['q'.$i.'answer']);
			?>
			</p>
			<?php
		}
		unset($_SESSION['poolsT_array']);
		unset($_SESSION['questions']);
		?>
		<form action="controller.php?method=nextpoll" method="post">
			<input type="submit" value="Next Poll">
		</form>
		<?php
	}
	else {

		?>
		<!-- MUDAR PARA GET -->
		<form action="controller.php?method=retrievepoll" method="post">
			<p>Id: <input type="text" name="id"></p>
			<input type="submit" value="Submit">
		</form>
		<?php
	}
?>

<input type="button" onclick="window.location = 'login.php';" value="Return"/>