<?php session_start();
include("config.php");
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  $username = $_POST['username'];
  $pword = $_POST['pword'];

  $stmt = $db->prepare('SELECT count(IdUser),Permission FROM Utilizador WHERE username = :user AND pword = :pword');
  $stmt->bindParam(':user',$username, PDO::PARAM_STR);
  $stmt->bindParam(':pword',$pword, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetch();

if($result[0] == 1)
{
// store session data
$_SESSION['username']=$username;
$_SESSION['Permission']=$result[1];
header("location: teste.php");
}
else {
echo "Wrong Username or Password";
}
}
echo '<div id="login">Login
            <form action="" method="post">
				<p>Username: <input type="text" name="username"/></p>
				<p>Password: <input type="password" name="pword"/></p>
				<p><input type="submit" value="Submit"/></p>
            </form>
		</div>
		<div id="register">
			<input type="button" onclick="window.location = \'register.php\';" value="Register">
		</div>';
?>