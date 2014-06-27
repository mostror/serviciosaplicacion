<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_poweradmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");
	
if(!isset($_GET['id']) AND !isset($_POST['answer']))
	header("Location: list_zones.php");

	poweradmin_panel();

if (isset($_POST['answer'])){
	if ($_POST['answer'] == "Yes"){
		mysql_query("delete from records where id=".$_POST['id']);
		edit_soa($_POST['zoneid']);
		die("<a href=\"edit_zone.php?&id=".$_POST['zoneid']."\">The record has been deleted successfully.</a>");
	}
	else {
		header("Location: edit_zone.php?&id=".$_POST['zoneid']);
	}
}

	$query=mysql_query("select domains.name, domains.id from domains, records where domains.id=records.domain_id and records.id=".$_GET['id']);
	$res=mysql_fetch_assoc($query);
	$zonename=$res['name'];
	$zoneid=$res['id'];
	
	echo "<h1>delete record in zone $zonename</h1>";
	
	$query=mysql_query("select * from records where id=".$_GET['id']);
	$res=mysql_fetch_assoc($query);
	
	echo "
	<table border=1>
		<tr>
			<td>
				Name
			</td>
			<td>
				Type
			</td>
			<td>
				Content
			</td>
			<td>
				TTL
			</td>
		</tr>
		<tr>
			<td>
				".$res['name']."
			</td>
			<td>
				".$res['type']."
			</td>
			<td>
				".$res['content']."
			</td>
			<td>
				".$res['ttl']."
			</td>
		</tr>
		</table>
		Are you sure? <br />
		<form action=\"delete_record.php\" method=\"post\">
		<input type=\"hidden\" value=\"$zonename\" name=\"zonename\">
		<input type=\"hidden\" value=\"$zoneid\" name=\"zoneid\">
		<input type=\"hidden\" value=".$_GET['id']." name=\"id\">
		<input name=\"answer\" type=\"submit\" value=\"Yes\"> <input name=\"answer\" type=\"submit\" value=\"No\">
		</form>
	";
?>