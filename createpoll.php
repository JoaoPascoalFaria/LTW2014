<?php session_start();
require_once('header.php');
	if (isset($_SESSION['error'])){
?>
<!-- HTML -->	<div style="color: red;"><?php echo $_SESSION['error']; ?></div>
<?php
	}
	else if(isset($_SESSION['success'])) {
?>
<!-- HTML -->	<div style="color: green;"><?php echo $_SESSION['success']; ?></div> 
<!-- HTML -->	<script type='text/javascript'>setTimeout(function() { window.location = "teste.php"; }, 3000);</script>
<?php
	}
	unset($_SESSION['error']);
	unset($_SESSION['success']);
?>

<html>
	<head>
		<script src="jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" type="text/css" href="Pollstyle.css">
		<script>
			$(document).ready(function() {
				var wrapper			= $(".poll_wrap"); //Fields wrapper
				var add_question	= $(".add_poll_question"); //Add button ID
				var x=1;

				$(add_question).click(function(e){ //on add input button click
					e.preventDefault();
					$("div#Questions").append("<div class='poll_wrap' id=" + (x) + "><input type='text' class= 'questionbox' name='question[]'/>/*<a href='#' class='remove_field'>Remove</a>*/<div id= group"+ (x) +" class='choices_wrap' value=0><a id= button"+x+ " class='add_choice'>Add Choice</a></div></div>"); //add input box
					var choicewrapper = document.getElementById( "group"+ x );
					var choice = document.getElementById( "button"+ x );
						var q = x-1;//serve para guardar as answers na db
					choice.addEventListener( "click", function( event ) {
						//alert( event.target.parentNode.id);
						//count how many choicebox elements in div with id = group + x so new choicebox id could be //incremented
						var count = $(choicewrapper).attr("value");
						console.log(count);
						count ++;
						$(choicewrapper).attr("value",count);
						$(choicewrapper).append("<input type='text' class='choicebox' name='answer" + (q) + "[]'/>");
					},  false );
					x++;
				});

				$(document).on('click', function(event) {
					console.log( event.target );
				});
			});
		</script>
	</head>
	<body>
		<form action="controller.php?method=createpoll" method="post">
			<p>Title: <input type="text" name="title"></p>
			<p>Image URL: <input type="text" name="image"></p> 
			<input type="radio" name="Polltype" value="public" checked>Public
			<br>
			<input type="radio" name="Polltype" value="private">Private
			<br>
			<button class="add_poll_question">Add More Questions</button>
			<div id="Questions"> 
			
			</div>
			<input type="submit" value="Submit">
		</form>
		<input type="button" onclick="window.location = 'login.php';" value="Return"/>
	</body>
</html>