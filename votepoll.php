<?php session_start();
	
	if (isset($_SESSION['error'])){
		?>
		<!-- HTML -->	<div style="color: red;"><?php echo $_SESSION['error']; ?></div>
		<?php
		unset($_SESSION['error']);
	}
	else if(isset($_SESSION['success'])) {
		?>
		<!-- HTML -->	<div style="color: green;"><?php echo $_SESSION['success']; ?></div> 
		<!-- HTML -->	<script type='text/javascript'>setTimeout(function() { window.location = "teste.php"; }, 3000);</script>
		<?php
		unset($_SESSION['success']);
	}
	else {
		if (isset($_SESSION['polltitle'])){
			?>
			<!-- HTML -->	<p>Title: <?php echo $_SESSION['polltitle']; ?></p>
			<!-- HTML -->	<p id="questions">Questions:<br>
			<form action="controller.php?method=votepoll" method="post">
			<?php
			for($i = 0; $i < count($_SESSION['questions']); $i++) {
				echo "<br>",$_SESSION['questions'][$i]; ?><br>
				<p id="answers">Choices:<br>
					<?php
					for($j = 0; $j < count($_SESSION['q'.$i.'answer']); $j++) {
						?>
						<input type="radio" name="<?php echo $i; ?>" value="<?php echo $_SESSION['q'.$i.'answerid'][$j]; ?>"><?php echo $_SESSION['q'.$i.'answer'][$j]; ?><br>
						<?php
					}
					?>
				</p>
				<?php
				unset($_SESSION['q'.$i.'answer']);
				unset($_SESSION['q'.$i.'answerid']);
			}
			?>
			<input type="hidden" name="count" value="<?php echo count($_SESSION['questions']); ?>">
			<input type="hidden" name="pollid" value="<?php echo $_SESSION['pollid']; ?>">
			<input type="submit" value="Vote!">
			</form>
			</p>
			<?php
			unset($_SESSION['polltitle']);
			unset($_SESSION['questions']);
			unset($_SESSION['pollid']);
			unset($_SESSION['pollImage']);
		}
	}
?>
<input type="button" onclick="window.location = 'login.php';" value="Return"/>