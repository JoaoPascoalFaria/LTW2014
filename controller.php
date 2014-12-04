<?php session_start();
include("config.php");
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	function register() {
		global $db;
		/*unset($_SESSION['error']);
		unset($_SESSION['success']);*/
	
		if( isset($_POST['name'])){
			
			$name = strtoupper($_POST['name']);
			$pw = $_POST['pw'];
			
			$stmt = $db->prepare('SELECT count(IdUser) FROM Utilizador WHERE username = :user');
			$stmt->bindParam(':user',$name, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch();
			
			if($result[0] > 0) {
				$_SESSION['error'] = "Failed! Username already exists";
			}
			else {
				$encryptedPass = md5($pw);
				$stmt = $db->prepare("INSERT INTO Utilizador (Username,Permission,Pword) VALUES('$name','1','$encryptedPass')");
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function login() {
		global $db;
		
		$username = strtoupper($_POST['username']);
		$pword = $_POST['pword'];
		$encryptedPass = md5($pword);
		$stmt = $db->prepare('SELECT count(IdUser), Permission, IdUser FROM Utilizador WHERE username = :user AND pword = :pword');
		$stmt->bindParam(':user',$username, PDO::PARAM_STR);
		$stmt->bindParam(':pword',$encryptedPass, PDO::PARAM_STR);
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
				
				//Cenas referente a imagem 
				if(isDomainAvailable($imag)){}
				else
				{$imag = 'images/default.jpg';}
				
				$userID = $_SESSION['id'];
				$stmt = $db->prepare("INSERT INTO Poll (Owner,Title,Image,PrivatePoll) VALUES('$userID','$title','$imag','$priv')");
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
			
			$stmt = $db->prepare('SELECT Image FROM Poll WHERE Id = :id');
			$stmt->bindParam(':id',$id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch();
			$_SESSION['pollImage'] = $result[0];
			
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
					array_push($answers, $result[$j]['Text']);
				}
				$_SESSION['q'.$i.'answer'] = $answers;
			}
		}
		header("Location: showpoll.php");
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function retrievepollforvote() {
		global $db;
		if( isset( $_POST['id'])) {
			
			$id = $_POST['id'];
			$_SESSION['pollid'] = $id;
			
			$stmt = $db->prepare('SELECT Title FROM Poll WHERE Id = :id');
			$stmt->bindParam(':id',$id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch();
			$_SESSION['polltitle'] = $result[0];
			
			$stmt = $db->prepare('SELECT Image FROM Poll WHERE Id = :id');
			$stmt->bindParam(':id',$id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch();
			$_SESSION['pollImage'] = $result[0];
			
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
				$stmt = $db->prepare('SELECT Id, Text FROM Answer WHERE QuestionId = :id');
				$stmt->bindParam(':id',$ids[$i], PDO::PARAM_STR);
				$stmt->execute();
				$result = $stmt->fetchall();
				$answers = array();
				$ansIds = array();
				for($j = 0; $j < count($result); $j++) {
					array_push($answers, $result[$j]['Text']);
					array_push($ansIds, $result[$j]['Id']);
				}
				$_SESSION['q'.$i.'answer'] = $answers;
				$_SESSION['q'.$i.'answerid'] = $ansIds;
			}
		}
		header("Location: votepoll.php");
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function retrieve_all_owner_polls() {
		global $db;
		if( isset( $_SESSION['id'])) {
			
			$id = $_SESSION['id'];
			$stmt = $db->prepare('SELECT Id , Title FROM Poll WHERE Owner = :id');
			$stmt->bindParam(':id',$id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetchall();
		
			$id_array=array();
			$poolsT_array = array();
			for($i = 0; $i < count($result); $i++) {
				array_push($id_array, $result[$i]['Id']);
				array_push($poolsT_array, $result[$i]['Title']);
			}
			$_SESSION['poolsT_array']=$poolsT_array;
			$_SESSION['id_array']=$id_array;
			$_SESSION['owner_array']=$owner_array;
		}
		header("Location: listpolls.php");
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function retrieve_all_polls() {
		global $db;

		$stmt = $db->prepare('SELECT Id , Title, Owner FROM Poll WHERE PrivatePoll = "public"');
		$stmt->execute();
		$result = $stmt->fetchall();

		$poolsT_array=array();
		$id_array=array();
		$owner_array= array();

		for($i = 0; $i < count($result); $i++) {
			array_push($poolsT_array, $result[$i]['Title']);
			array_push($owner_array, $result[$i]['Owner']);
			array_push($id_array, $result[$i]['Id']);
		}
		$_SESSION['poolsT_array']=$poolsT_array;
		$_SESSION['id_array']=$id_array;
		$_SESSION['owner_array']=$owner_array;

		
		header("Location: listpolls.php");
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function show_poll_results() {
		if(isset($_SESSION['pollid'])) {

		}
		else
			var_dump('no poll assigned');
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function edit_poll() {
		?>
		<p> <?php echo $_SESSION['pollid'] ; ?> </p>
		<button class="add_poll_question">Add More Questions</button>
		<div id="Questions"> 
		<?php 
		echo $_SESSION['poolsT_array'][$_SESSION['pollid']] ;
		for($i=0; $i < count( $_SESSION['questions'] ) ; $i++)
		{
			echo $_SESSION['questions'][$i];
			for ($j=0; $j < count($_SESSION['q'.$i.'answer']); $j++ )
			{
				echo $_SESSION['q'.$i.'answer'][$j];
			}

		}
			?>
		</div>
		<input type="text" placeholder="<?php echo $_SESSION['poolsT_array'][$_SESSION['pollid']] ?>" >
		<input type="submit" value="submit">
		<?php
	///$_SESSION['pollid'] $_SESSION['q'.$i.'answer'] = $answers;$_SESSION['questions'] 
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function votepoll() {
		global $db;
		if( isset($_SESSION['id'])) {
			$idUser = $_SESSION['id'];
			$idpoll = $_POST['pollid'];
			
			$stmt = $db->prepare('SELECT count(idUtilizador) FROM UtilizadorAnswer WHERE idPoll = :idPoll AND idUtilizador = :iduser');
			$stmt->bindParam(':iduser',$idUser, PDO::PARAM_STR);
			$stmt->bindParam(':idPoll',$idpoll, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch();
			
			if($result[0] > 0) {
				$_SESSION['error'] = "Failed! You already voted on this Poll";
			}
			else {				
				for($i = 0; $i < $_POST['count']; $i++) {
					$idAns = $_POST["$i"];
					$idPol = $_POST['pollid'];
					$stmt = $db->prepare("INSERT INTO UtilizadorAnswer (idUtilizador, idAnswer, idPoll) VALUES('$idUser','$idAns', '$idPol')");
					$stmt->execute();
				}
				$_SESSION['success'] = "Successfully Voted";
			}
		}
		header("Location: votepoll.php");
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
		else if($method == "retrieve_all_owner_polls")
			retrieve_all_owner_polls();
		else if($method == "retrieve_all_polls")
			retrieve_all_polls();
		else if($method == "show_poll_results")
			show_poll_results();
		else if($method == "edit_poll")
			edit_poll();
		else if ($method == "votepoll")
			votepoll();
		else if ($method == "retrievepollforvote")
			retrievepollforvote();
	}
	
		function isDomainAvailable($domain)
	{

	if(!filter_var($domain, FILTER_VALIDATE_URL))
		{
			return false;
		}
		
		$curlInit = curl_init($domain);
		curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
		curl_setopt($curlInit,CURLOPT_HEADER,true);
		curl_setopt($curlInit,CURLOPT_NOBODY,true);
		curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
		//get answer
		$response = curl_exec($curlInit);
		curl_close($curlInit);
		if ($response) return true;
		return false;
	}	
	
	
	router();
?>