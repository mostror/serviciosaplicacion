<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_postfixadmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

if(!isset($_GET['mailbox']))
	header("Location:virtual_list.php");

	poweradmin_panel();

if (isset($_POST['answer'])){
	if ($_POST['answer'] == "No")
		{
			$exp=explode("@", $_GET['mailbox']);
			print_r($exp);
			die("");
			header("Location:virtual_list.php?domain=".$exp[1]);
		}
	else{
		mysql_query($string= "delete from mailbox where username=\"".$_GET['mailbox']."\"")or die($string) ;
		mysql_query($string= "delete from alias where address=\"".$_GET['mailbox']."\" AND goto=\"".$_GET['mailbox']."\"")or die($string) ;
		
		echo "<h1>Delete mailbox \"".$_GET['mailbox']."\"</h1>";

		die ("Domain has been deleted successfully.");
	}
	
}
	
	echo "<h1>Delete domain \"".$_GET['mailbox']."\"</h1>";
	
	echo "<br />Are you sure? </br >
		<form action=\"delete_mailbox.php?mailbox=".$_GET['mailbox']."\" method=\"post\">
		<input name=\"answer\" type=\"submit\" value=\"Yes\"> <input name=\"answer\" type=\"submit\" value=\"No\">
		</form>
	";
?>