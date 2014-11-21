<?php session_start();
include("config.php");
  
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$name = $_POST['name'];
	$pw = $_POST['pw'];
	
	$stmt = $db->prepare('SELECT count(IdUser),Permission FROM Utilizador WHERE username = :user');
	$stmt->bindParam(':user',$name, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetch();
	
	if($result[0] == 1) {
		echo "Failed! Username already exists";
	}
	else {
		$stmt = $db->prepare("INSERT INTO Utilizador (Username,Permission,Pword) VALUES('$name','1','$pw')");
		$flag = $stmt->execute();
		if($flag == 1){
			echo "<script type='text/javascript'>alert(\"Successfully Inserted\"); window.location = \"teste.php\";</script>";
		}
		else
			echo "Failed! An Error has occurred";
	}
}
else {
	echo
	'<form id="register" action="" method="post">
		UserName: <input type="text" name="name"><br/>
		Password: <input type="password" name="pw"><br/>
		<input type="submit"/>
	</form>';
}
?>