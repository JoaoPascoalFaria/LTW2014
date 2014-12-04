<?php session_start();

	if (isset($_SESSION['polltitle'])){
		?>
		<!-- HTML -->	<p>Title: <?php echo $_SESSION['polltitle']; ?></p>
		<!-- HTML -->	<p id="questions">Questions:<br>
		<!-- HTML -->	<form action="controller.php?method=editpoll" method="post">
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
		}
		?>
		<input type="submit" value="Submit">
		</form>
		</p>
		<?php
		unset($_SESSION['polltitle']);
		unset($_SESSION['questions']);
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
<input type="button" onclick="window.location = 'showpoll.php';" value="Return"/>