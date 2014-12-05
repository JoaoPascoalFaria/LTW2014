<?php session_start();
	require_once('header.php');
	if (isset($_SESSION['polltitle'])){
		
		?>
		<div class="row row-margin-bottom">
		<div class="col-md-5 no-padding lib-item" data-category="view">
			<div class="lib-panel">
				<div class="row box-shadow">
					   <div class="col-md-6">   
			<!-- HTML -->	<img class="lib-img-show" src= "<?php echo $_SESSION['pollImage']; ?>">		
						</div>
						<div class="col-md-6">
							<div class="lib-row lib-header">					
			<!-- HTML -->	<p>Title: <?php echo $_SESSION['polltitle']; ?></p>
							<div class="lib-header-seperator"></div>
							  </div>
							  <div class="lib-row lib-desc">
			<!-- HTML -->	<p id="questions">Questions:<br>
		<?php
		for($i = 0; $i < count($_SESSION['questions']); $i++) {
			echo "<br>",$_SESSION['questions'][$i]; ?><br>
			<p id="answers">Choices:<br>
				<?php
				for($j = 0; $j < count($_SESSION['q'.$i.'answer']); $j++) {
					echo $j+1,": ",$_SESSION['q'.$i.'answer'][$j],"    ";
					echo $_SESSION['q'.$i.'answercount'][$j],"<br>";
				}
				?>
			</p>
			<?php
			unset($_SESSION['q'.$i.'answer']);
			unset($_SESSION['q'.$i.'answercount']);
		}
		?>
		
		</p>
						</div>
					</div>
				</div>
			</div>
        </div>
		
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
<input type="button" onclick="window.location = 'login.php';" value="Return"/>
</body>
</html>