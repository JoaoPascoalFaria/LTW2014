<?php
include("config.php");
  session_start();
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
              <ul><form action="" method="post">
              <li><p>Username: <input type="text" name="username"/></p></li>
              <li><p>Password: <input type="password" name="pword"/></p></li>
              <li><p><input type="submit"/></p></li>\
              </form></ul></div>';
  
?>