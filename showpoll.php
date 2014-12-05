<?php session_start();
	require_once('header.php');
	
	if (isset($_SESSION['error'])){
		?>
		<!-- HTML -->	<div style="color: red;"><?php echo $_SESSION['error']; ?></div>
		<?php
		unset($_SESSION['error']);
	}
	if(isset($_SESSION['success'])) {
		?>
		<!-- HTML -->	<div style="color: green;"><?php echo $_SESSION['success']; ?></div> 
		<!-- HTML -->	<script type='text/javascript'>setTimeout(function() { window.location = "teste.php"; }, 3000);</script>
		<?php
		unset($_SESSION['success']);
	}
	
	
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
					echo $j+1,": ",$_SESSION['q'.$i.'answer'][$j],"<br>";
				}
				?>
			</p>
			<?php
			unset($_SESSION['q'.$i.'answer']);
		}
		?>
		
		</p>
						</div>
					</div>
				</div>
			</div>
        </div>
		<form action="controller.php?method=retrievepoll" method="post">
			<input type="hidden" name="id" value="<?php echo ($_SESSION['pollid']+1); ?>">
			<input type="submit" value="Next Poll">
		</form>
		<form action="controller.php?method=retrievepollforvote" method="post">
			<input type="hidden" name="id" value="<?php echo $_SESSION['pollid']; ?>">
			<input type="submit" value="Vote This Poll">
		</form>
		<form action="controller.php?method=show_poll_results" method="post">
			<input type="hidden" name="id" value="<?php echo $_SESSION['pollid']; ?>">
			<input type="submit" value="Show results">
		</form>
		<form action="controller.php?method=deletepoll" method="post">
			<input type="hidden" name="id" value="<?php echo $_SESSION['pollid']; ?>">
			<input type="submit" value="Delete Poll">
		</form>
		<form action="controller.php?method=closepoll" method="post">
			<input type="hidden" name="id" value="<?php echo $_SESSION['pollid']; ?>">
			<input type="submit" value="Close Poll">
		</form>
		
		<?php
		unset($_SESSION['polltitle']);
		unset($_SESSION['questions']);
		unset($_SESSION['pollImage']);
		unset($_SESSION['pollid']);
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