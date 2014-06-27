<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_postfixadmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

if(!isset($_GET['domain']))
	header("Location:list_domains.php");	

	poweradmin_panel();
	
	$query=mysql_query("select * from domain where domain=\"".$_GET['domain']."\"");
	if (mysql_num_rows($query) == 0){
		die("Invalid domain");
	}
	
	echo "<h1>Edit domain ".$_GET['domain']."</h1>";

	if (isset($_POST['active'])){
			
		
		mysql_query($string="update domain set 
		description= \"".$_POST['description']."\",
		aliases= ".$_POST['aliases'].",
		mailboxes= ".$_POST['mailboxes'].",
		quota= ".$_POST['quota'].",
		backupmx=  ".$_POST['backupmx'].",
		modified= CURRENT_TIMESTAMP(),
		active= ".$_POST['active']."
		WHERE domain=\"".$_GET['domain']."\"") or die($string);
		
		echo "The domain ".$_GET['domain']." has been updated.";
		$query=mysql_query("select * from domain where domain=\"".$_GET['domain']."\"");
	}

	$res=mysql_fetch_assoc($query);
	echo "<form action=\"edit_domain.php?domain=".$_GET['domain']."\" method=\"post\">
	<table border=1>
		<tr>
			<td>
				Domain:
			</td>
			<td>
				 ".$_GET['domain']."
			</td>
		</tr>
		<tr>
			<td>
				Description:
			</td>
			<td>
				<input type=\"text\" name=\"description\" value=\"".$res['description']."\">
			</td>
		</tr>
		<tr>
			<td>
				Aliases:
			</td>
			<td>
				<input type=\"text\" name=\"aliases\" value=\"".$res['aliases']."\">	
			</td>
			<td>
				-1 = disable | 0 = unlimited
			</td>
		</tr>
		<tr>
			<td>
				Mailboxes:
			</td>
			<td>
				<input type=\"text\" name=\"mailboxes\" value=\"".$res['mailboxes']."\">	
			</td>
			<td>
				-1 = disable | 0 = unlimited
			</td>
		</tr>
		<tr>
			<td>
				Domain Quota:
			</td>
			<td>
				<input type=\"text\" name=\"quota\" value=\"".$res['quota']."\">	
			</td>
			<td>
				Mb | -1 = disable | 0 = unlimited
			</td>
		</tr>
		<tr>
			<td>
				Mail server is backup MX:
			</td>
			<td>
				<input type=\"hidden\" value=\"0\" name=\"backupmx\">
				<input type=\"checkbox\" name=\"backupmx\" value=\"".$res['backupmx']."\">
			</td>
		</tr>
				<tr>
			<td>
				Active:
			</td>
			<td>
				<input type=\"hidden\" value=\"0\" name=\"active\">
				<input type=\"checkbox\" name=\"active\" value=\"".$res['active']."\">
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type=\"submit\" value=\"Save changes\"></td>
	</table></form>";
	

?>