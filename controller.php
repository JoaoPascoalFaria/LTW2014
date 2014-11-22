<?php session_start();
include("config.php");
	
	function register() {
		global $db;
		/*unset($_SESSION['error']);
		unset($_SESSION['success']);*/
	
		if( isset($_POST['name'])){
			
			$name = $_POST['name'];
			$pw = $_POST['pw'];
			
			$stmt = $db->prepare('SELECT count(IdUser),Permission FROM Utilizador WHERE username = :user');
			$stmt->bindParam(':user',$name, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch();
			
			if($result[0] == 1) {
				$_SESSION['error'] = "Failed! Username already exists";
			}
			else {
				$stmt = $db->prepare("INSERT INTO Utilizador (Username,Permission,Pword) VALUES('$name','1','$pw')");
				$flag = $stmt->execute();
				if($flag == 1){
					$_SESSION['success'] = "Successfully Inserted";
				}
				else{
					$_SESSION['error'] = "Failed! An Error has occurred";
				}
			}
		}
		header("Location: register.php");
	}

	function login() {
		global $db;
		
		$username = $_POST['username'];
		$pword = $_POST['pword'];
		
		$stmt = $db->prepare('SELECT count(IdUser),Permission FROM Utilizador WHERE username = :user AND pword = :pword');
		$stmt->bindParam(':user',$username, PDO::PARAM_STR);
		$stmt->bindParam(':pword',$pword, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch();

		if($result[0] == 1) {
			// store session data
			$_SESSION['username']=$username;
			$_SESSION['Permission']=$result[1];
		}
		else {
			$_SESSION['error'] = "Wrong Username or Password";
		}
		header("Location: login.php");
	}
	
	function router()
	{
		$method = $_GET['method'];
		if ($method == "register")
			register();
		else if($method == "login")
			login();
	}
	
	router();
?>