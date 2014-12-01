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

		if($result[0] > 0) {
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
	
	function retrievepoll() {
		global $db;
		if( isset( $_POST['id'])) {
			
			$id = $_POST['id'];
			$_SESSION['pollid'] = $id;
			
			$stmt = $db->prepare('SELECT Title FROM Poll WHERE Id = :id');
			$stmt->bindParam(':id',$id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch();
			$_SESSION['polltitle'] = $result[0];
			
			$stmt = $db->prepare('SELECT Id, Text FROM Question WHERE PollId = :id');
			$stmt->bindParam(':id',$id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchall();
			$qsts = array();
			$ids = array();
			for($i = 0; $i < count($result); $i++) {
				
				array_push($ids, $result[$i]['Id']);
				array_push($qsts, $result[$i]['Text']);
			}
			$_SESSION['questions'] = $qsts;
			for($i = 0; $i < count($ids); $i++) {
				$stmt = $db->prepare('SELECT Text FROM Answer WHERE QuestionId = :id');
				$stmt->bindParam(':id',$ids[$i], PDO::PARAM_STR);
				$stmt->execute();
				$result = $stmt->fetchall();
				$answers = array();
				for($j = 0; $j < count($result); $j++) {
					var_dump($result[$j]);
					array_push($answers, $result[$j]['Text']);
				}
				$_SESSION['q'.$i.'answer'] = $answers;
			}
		}
		header("Location: showpoll.php");
	}

	function nextpoll()
	{
		global $db;
		if( isset( $_SESSION['pollid'])) {
			
			$id = $_SESSION['pollid'] + 1;
			$_SESSION['pollid'] ++ ;
			
			$stmt = $db->prepare('SELECT Title FROM Poll WHERE Id = :id');
			$stmt->bindParam(':id',$id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch();
			$_SESSION['polltitle'] = $result[0];
			
			$stmt = $db->prepare('SELECT Id, Text FROM Question WHERE PollId = :id');
			$stmt->bindParam(':id',$id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchall();
			$qsts = array();
			$ids = array();
			for($i = 0; $i < count($result); $i++) {
				
				array_push($ids, $result[$i]['Id']);
				array_push($qsts, $result[$i]['Text']);
			}
			$_SESSION['questions'] = $qsts;
			for($i = 0; $i < count($ids); $i++) {
				$stmt = $db->prepare('SELECT Text FROM Answer WHERE QuestionId = :id');
				$stmt->bindParam(':id',$ids[$i], PDO::PARAM_STR);
				$stmt->execute();
				$result = $stmt->fetchall();
				$answers = array();
				for($j = 0; $j < count($result); $j++) {
					var_dump($result[$j]);
					array_push($answers, $result[$j]['Text']);
				}
				$_SESSION['q'.$i.'answer'] = $answers;
			}
		}
		header("Location: showpoll.php");
	}


	function retrieve_all_owner_polls() {
		global $db;
		if( isset( $_SESSION['id'])) {
			
			$id = $_SESSION['id'];
			$stmt = $db->prepare('SELECT Id , Title FROM Poll WHERE Owner = :id');
			$stmt->bindParam(':id',$id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchall();
		
			$ownerpoolsI=array();
			$ownerpoolsT = array();
			for($i = 0; $i < count($result); $i++) {
				array_push($ownerpoolsI, $result[$i]['Id']);
				array_push($ownerpoolsT, $result[$i]['Title']);
			}
			$_SESSION['ownpolls']=$ownerpoolsT;
			$_SESSION['ownpollsIds']=$ownerpoolsI;
		}
		header("Location: listpolls.php");
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
		else if($method == "retrievepoll")
			retrievepoll();
		else if($method == "nextpoll")
			nextpoll();
		else if($method == "retrieve_all_owner_polls")
			retrieve_all_owner_polls();

	}
	
	router();
?>