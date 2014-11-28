<?php
session_start();
include("config.php");
if($_SERVER["REQUEST_METHOD"] == "GET")
{
  $polltype = $_GET['Polltype'];
  //$questions = $_GET['myquestions'];
   $choices = $_GET['mychoices'];
}


  /*$stmt = $db->prepare('SELECT count(IdUser),Permission FROM Utilizador WHERE username = :user AND pword = :pword');
  $stmt->bindParam(':user',$username, PDO::PARAM_STR);
  $stmt->bindParam(':pword',$pword, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetch();
  */
var_dump($polltype);
var_dump($choices);
?>
