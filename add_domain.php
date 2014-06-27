<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_postfixadmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

	poweradmin_panel();
	echo "<h1>Add domain</h1>";

	if (isset($_POST['domain'])){
		$query=mysql_query("select * from domain where domain=\"".$_POST['domain']."\"");

		if (mysql_num_rows($query) > 0)
			echo "The domain already exists!";
		elseif (!preg_match("^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$^", $_POST['domain'])) {
			echo "Invalid domain name navasdfaf, fails regexp check.";
		}
		else {
			mysql_query($string="insert into domain (domain, description, aliases, mailboxes, maxquota, quota, transport, backupmx, created, modified, active) values
			(\"".$_POST['domain']."\", \"".$_POST['description']."\", ".$_POST['aliases'].", ".$_POST['mailboxes'].", 10, ".$_POST['quota'].", \"virtual\", ".$_POST['backupmx'].", CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), ".$_POST['active'].")") or die($string);
			
			echo "The domain ".$_POST['domain']." has been added.";
			echo "<hr />";
		}
	}


	echo "<form action=\"add_domain.php\" method=\"post\">
	<table border=1>
		<tr>
			<td>
				Domain:
			</td>
			<td>
				 <input type=\"text\" name=\"domain\">
			</td>
		</tr>
		<tr>
			<td>
				Description:
			</td>
			<td>
				<input type=\"text\" name=\"description\">
			</td>
		</tr>
		<tr>
			<td>
				Aliases:
			</td>
			<td>
				<input type=\"text\" name=\"aliases\" value=10>	
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
				<input type=\"text\" name=\"mailboxes\" value=10>	
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
				<input type=\"text\" name=\"quota\" value=2048>	
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
				<input type=\"checkbox\" value=\"1\" name=\"backupmx\">
			</td>
		</tr>
				<tr>
			<td>
				Active:
			</td>
			<td>
				<input type=\"hidden\" value=\"0\" name=\"active\">
				<input type=\"checkbox\" name=\"active\" value=\"1\" checked>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type=\"submit\" value=\"Add domain\"></td>
	</table></form>";
?>