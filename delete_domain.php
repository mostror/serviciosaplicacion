<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_postfixadmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

if(!isset($_GET['domain']) AND !isset($_POST['answer']))
	header("Location:list_zones.php");

	poweradmin_panel();

if (isset($_POST['answer'])){
	if ($_POST['answer'] == "No")
		header("Location:list_domains.php");
	else{
		mysql_query($string= "delete from mailbox where domain=\"".$_GET['domain']."\"")or die($string) ;
		mysql_query($string= "delete from alias where domain=\"".$_GET['domain']."\"")or die($string);
		mysql_query($string= "delete from domain where domain=\"".$_GET['domain']."\"")or die($string);
	
		echo "<h1>Delete domain \"".$_GET['domain']."\"</h1>";

		die ("Domain has been deleted successfully.");
	}
	
}
	
	echo "<h1>Delete domain \"".$_GET['domain']."\"</h1>";
	
	echo "<br />Are you sure? </br >
		<form action=\"delete_domain.php?domain=".$_GET['domain']."\" method=\"post\">
		<input name=\"answer\" type=\"submit\" value=\"Yes\"> <input name=\"answer\" type=\"submit\" value=\"No\">
		</form>
	";
?>