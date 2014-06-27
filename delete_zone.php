<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_poweradmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

if(!isset($_GET['id']) AND !isset($_POST['answer']))
	header("Location:list_zones.php");

	poweradmin_panel();

if (isset($_POST['answer'])){
	if ($_POST['answer'] == "No")
		header("Location:list_zones.php");
	else{
		mysql_query("delete from records where domain_id=".$_POST['id']);
		mysql_query("delete from zones where domain_id=".$_POST['id']);
		mysql_query("delete from domains where id=".$_POST['id']);
	
		echo "<h1>Delete zone \"".$_POST['zonename']."\"</h1>";

		die ("Zone has been deleted successfully.");
	}
	
}
	
	$query=mysql_query($string = "select domains.name, domains.type, users.fullname from domains, users, zones where
	
	domains.id=zones.domain_id AND
	users.id=zones.owner AND
	domains.id =".$_GET['id']
	) or die($string);
	
	$res=mysql_fetch_assoc($query);
	
	echo "<h1>Delete zone \"".$res['name']."\"</h1>";
	
	echo "
		Owner: ".$res['fullname']."<br .>
		Type: ".$res['type']."<br .>
		<br />Are you sure? </br >
		<form action=\"delete_zone.php\" method=\"post\">
		<input type=\"hidden\" value=\"".$res['name']."\" name=\"zonename\">
		<input type=\"hidden\" value=".$_GET['id']." name=\"id\">
		<input name=\"answer\" type=\"submit\" value=\"Yes\"> <input name=\"answer\" type=\"submit\" value=\"No\">
		</form>
	";
?>