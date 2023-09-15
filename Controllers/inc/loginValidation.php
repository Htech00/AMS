<?php 
require_once('../classes/main_class.php');
session_start();
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$main = new main();
		$sql = "SELECT * FROM user WHERE `username` ='".$username."' AND `password` ='".$password."'";
		$query = $main->query($sql);
		$num_rows = $main->num_rows($query);
		if($num_rows==1){
			echo 1;
		}else{
			return false;
		}
		$_SESSION['username']=$username;
?>