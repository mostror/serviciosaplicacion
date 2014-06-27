<?php
session_start();
include "funciones.php";
include("conexiones.php");
conectar_userlogin();


if(isset($_POST['action']))
	if ($_POST['action'] == "login"){
		$username=mysql_real_escape_string($_POST['username']);
		$password=mysql_real_escape_string($_POST['password']);
		
		$query=mysql_query("SELECT * FROM users WHERE username='$username'");
		
		
		if(mysql_num_rows($query)==1)
		{
			$res=mysql_fetch_assoc($query);
			$exp=explode("$", $res['password']);
			
			if (crypt($password, "$".$exp[1]."$".$exp[2]."$") == $res['password']){
				$_SESSION['username']=$res['username'];
				$_SESSION['password']=$res['password'];
				$_SESSION['email']=$res['email'];
				header("Location: home.php");
			}
			else
			die ("Wrong username or password. <a href=\"index.php\">Return</a> <br />");
		}
		if (mysql_num_rows($query)==0)
		{
			die ("Wrong username or password. <a href=\"index.php\">Return</a>");
		}
	}
?>
