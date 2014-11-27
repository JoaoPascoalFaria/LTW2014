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
		
		$stmt = $db->prepare('SELECT count(IdUser) FROM Utilizador WHERE username = :user AND pword = :pword');
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
	
	function createpoll() {
		global $db;
		if( isset($_POST['title']) and isset($_SESSION['username'])){
			
			$title = $_POST['title'];
			$qst = $_POST['question'];
			$ans1 = $_POST['answer1'];
			$ans2 = $_POST['answer2'];
			$priv = $_POST['private'];
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
				$stmt = $db->prepare('SELECT IdUser FROM Utilizador WHERE Username = :usr');
				$stmt->bindParam(':usr',$user, PDO::PARAM_STR);
				$stmt->execute();
				$result = $stmt->fetch();
				$userID = $result[0];
				
				$stmt = $db->prepare("INSERT INTO Poll (Owner,Title,PrivatePoll) VALUES('$userID','$title','$priv')");
				$flag = $stmt->execute();
				if($flag != 1){
					$_SESSION['error'] = "Failed! An Error has occurred while creating poll";
					header("Location: createpoll.php");
				}
				/* Question */
				$stmt = $db->prepare('SELECT Id FROM Poll WHERE Title = :titl');
				$stmt->bindParam(':titl',$title, PDO::PARAM_STR);
				$stmt->execute();
				$result = $stmt->fetch();
				$pollID = $result[0];
				
				$stmt = $db->prepare("INSERT INTO Question (PollId,Text) VALUES('$pollID','$qst')");
				$flag = $stmt->execute();
				if($flag != 1){
					$_SESSION['error'] = "Failed! An Error has occurred while creating question";
					header("Location: createpoll.php");
				}
				/* Answer */
				$stmt = $db->prepare('SELECT Id FROM Question WHERE Text = :quest AND PollId = :pid');
				$stmt->bindParam(':quest',$qst, PDO::PARAM_STR);
				$stmt->bindParam(':pid',$pollID, PDO::PARAM_STR);
				$stmt->execute();
				$result = $stmt->fetch();
				$questionID = $result[0];
				
				$stmt = $db->prepare("INSERT INTO Answer (QuestionId,Text,VotesCount) VALUES('$questionID','$ans1','0')");
				$flag = $stmt->execute();
				if($flag != 1){
					$_SESSION['error'] = "Failed! An Error has occurred while creating answer 1";
					header("Location: createpoll.php");
				}
				$stmt = $db->prepare("INSERT INTO Answer (QuestionId,Text,VotesCount) VALUES('$questionID','$ans2','0')");
				$flag = $stmt->execute();
				if($flag != 1){
					$_SESSION['error'] = "Failed! An Error has occurred while creating answer 2";
					header("Location: createpoll.php");
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