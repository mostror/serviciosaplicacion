<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_postfixadmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

if(!isset($_GET['mailbox']))
	header("Location:list_domains.php");	

	poweradmin_panel();
	
	$query=mysql_query("select * from mailbox where username=\"".$_GET['mailbox']."\"");
	if (mysql_num_rows($query) == 0){
		die("Invalid mailbox");
	}
	
	echo "<h1>Edit mailbox ".$_GET['mailbox']."</h1>";

	if (isset($_POST['active'])){
			
		if ($_POST['password'] == $_POST['password2'])
		
		{
			if ($_POST['password'] != "")
				$pquery="password= \"".crypt($_POST['password'])."\", ";
			else
				$pquery="";
			
			mysql_query($string="update mailbox set
			
			$pquery
			name= \"".$_POST['name']."\",
			quota= ".$_POST['quota'].",
			modified= CURRENT_TIMESTAMP(),
			active= ".$_POST['active']."
			WHERE username=\"".$_GET['mailbox']."\"") or die($string);
			
			echo "The mailbox ".$_GET['mailbox']." has been updated.";
		}
		else
			echo "The passwords do not match.";
		$query=mysql_query("select * from mailbox where username=\"".$_GET['mailbox']."\"");
	}

	$res=mysql_fetch_assoc($query);
	echo "<form action=\"edit_mailbox.php?mailbox=".$_GET['mailbox']."\" method=\"post\">
	<table border=1>
		<tr>
			<td>
				Username:
			</td>
			<td>
				 ".$res['username']."
			</td>
		</tr>
		<tr>
			<td>
				Password:
			</td>
			<td>
				<input type=\"password\" name=\"password\">	
			</td>
		</tr>
		<tr>
			<td>
				Password (again):
			</td>
			<td>
				<input type=\"password\" name=\"password2\">	
			</td>
		</tr>
		<tr>
			<td>
				name:
			</td>
			<td>
				<input type=\"text\" name=\"name\" value=\"".$res['name']."\">
			</td>
			<td>
				Full name
			</td>
		</tr>
		<tr>
			<td>
				Quota:
			</td>
			<td>
				<input type=\"text\" name=\"quota\" value=\"".$res['quota']."\">	
			</td>
			<td>
				MB
			</td>
		</tr>
		<tr>
			<td>
				Active:
			</td>
			<td>
				<input type=\"hidden\" value=\"0\" name=\"active\">
				<input type=\"checkbox\" name=\"active\" value=\"1\" ".($res['active'] == "1" ? "checked" : "").">
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type=\"submit\" value=\"Save changes\"></td>
	</table></form>";
	

?>