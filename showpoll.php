<?php session_start();

	if (isset($_SESSION['polltitle'])){
		?>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="Pollstyle.css">
	</head>
	<body>
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
		<form action="controller.php?method=edit_poll" method="post">
			<input type="submit" value="Edit Mode">
		</form>
		<input type="button" onclick="window.location = 'editpoll.php';" value="Edit Poll"/>
		<form action="controller.php?method=retrievepollforvote" method="post">
			<input type="hidden" name="id" value="<?php echo $_SESSION['pollid']; ?>">
			<input type="submit" value="Vote This Poll">
		</form>

		
		
		<?php
		unset($_SESSION['polltitle']);
		unset($_SESSION['questions']);
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