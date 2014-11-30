<?php session_start();
include("config.php");
	
	function register() {
		global $db;
		/*unset($_SESSION['error']);
		unset($_SESSION['success']);*/
	
		if( isset($_POST['name'])){
			
			$name = $_POST['name'];
			$pw = $_POST['pw'];
			
			$stmt = $db->prepare('SELECT count(IdUser) FROM Utilizador WHERE username = :user');
			$stmt->bindParam(':user',$name, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch();
			
			if($result[0] > 0) {
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
		
		$stmt = $db->prepare('SELECT count(IdUser), Permission, IdUser FROM Utilizador WHERE username = :user AND pword = :pword');
		$stmt->bindParam(':user',$username, PDO::PARAM_STR);
		$stmt->bindParam(':pword',$pword, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch();

		if($result[0] == 1) {
			// store session data
			$_SESSION['username']=$username;
			$_SESSION['Permission']=$result[1];
			$_SESSION['id']=$result[2];
		}
		else {
			$_SESSION['error'] = "Wrong Username or Password";
		}
		header("Location: login.php");
	}
	
	function createpoll() {
		global $db;
		if( isset($_POST['title']) and isset($_SESSION['id'])){
			
			$title = $_POST['title'];
			$qst = $_POST['question'];
			$priv = $_POST['Polltype'];
			$user = $_SESSION['username'];
			
			$stmt = $db->prepare('SELECT count(Id) FROM Poll WHERE Title = :titl');
			$stmt->bindParam(':titl',$title, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch();
			
			if($result[0] > 0) {
				$_SESSION['error'] = "Failed! Title already exists";
			}
			else {
				/* Poll */
				$userID = $_SESSION['id'];
				$stmt = $db->prepare("INSERT INTO Poll (Owner,Title,PrivatePoll) VALUES('$userID','$title','$priv')");
				$flag = $stmt->execute();
				if($flag != 1){
					$_SESSION['error'] = "Failed! An Error has occurred while creating poll";
					header("Location: createpoll.php");
				}
				
				/* Question */
				$pollID = $db->lastInsertId();
				for($i = 0; $i < count($qst); $i++) {
					$stmt = $db->prepare("INSERT INTO Question (PollId,Text) VALUES('$pollID','$qst[$i]')");
					$flag = $stmt->execute();
					if($flag != 1){
						$_SESSION['error'] = "Failed! An Error has occurred while creating question";
						header("Location: createpoll.php");
					}
					
					/* Answer */
					$questionID = $db->lastInsertId();
					$ans = $_POST['answer'.$i];
					for($j = 0; $j < count($ans); $j++) {
						$stmt = $db->prepare("INSERT INTO Answer (QuestionId,Text) VALUES('$questionID','$ans[$j]')");
						$flag = $stmt->execute();
						if($flag != 1){
							$_SESSION['error'] = "Failed! An Error has occurred while creating answer 1";
							header("Location: createpoll.php");
						}
					}
				}
				$_SESSION['success'] = "Successfully created Poll";
			}
		}
		header("Location: createpoll.php");
	}
	
	function router()
	{
		$method = $_GET['method'];
		if ($method == "register")
			register();
		else if($method == "login")
			login();
		else if($method == "createpoll")
			createpoll();
	}
	
	router();
?>