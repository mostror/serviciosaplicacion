<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_postfixadmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

	poweradmin_panel();

	echo "<h1>Add mailbox</h1>";
	
	if (isset($_POST['domain'])){
		
		$mail=$_POST['username']."@".$_POST['domain'];
		
		$query=mysql_query("select count(*) as count, domain.mailboxes from domain, mailbox where mailbox.domain=\"".$_POST['domain']."\" AND mailbox.domain=domain.domain group by mailbox.domain");
		$res=mysql_fetch_assoc($query);
		$query=mysql_query("select * from mailbox where username=\"$mail\"");
		if ($res['mailboxes'] <= $res['count'])
			echo "Mailbox capacity reached";
		
		elseif (mysql_num_rows($query) > 0)
			echo "The mailbox already exists!";
		
		elseif ($_POST['password'] != $_POST['password2'])
			echo "The passwords do not match.";
		
		else {

			$crypt=crypt($_POST['password']);
			mysql_query($string="insert into mailbox (username, password, name, maildir, quota, local_part, domain, created, modified, active) values
			(\"$mail\", \"$crypt\", \"".$_POST['name']."\", \"".$_POST['domain']."/".$_POST['username']."/\", ".($_POST['quota'] == "" ? "0" : $_POST['quota']."").", \"".$_POST['username']."\", \"".$_POST['domain']."\",
			CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), ".$_POST['active'].")")or die($string);
			mysql_query($string="insert into alias (address, goto, domain, created, modified, active) values
			(\"$mail\", \"$mail\", \"".$_POST['domain']."\", CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), ".$_POST['active'].")")or die($string);
			mail($mail, "Wellcome", "Wellcome!");
			
			
			
			echo "The mailbox ".$_POST['username']."@".$_POST['domain']." has been created.";
			echo "<hr />";
		}
	}

	$domainsquery=mysql_query("select domain from domain where domain != \"ALL\"order by domain");

	echo "<form action=\"add_mailbox.php\" method=\"post\">
	<table border=1>
		<tr>
			<td>
				username:
			</td>
			<td>
				 <input type=\"text\" name=\"username\">
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<select name=\"domain\">";
		while ($domainres=mysql_fetch_assoc($domainsquery))
			echo "<option value=\"".$domainres['domain']."\">".$domainres['domain']."</option>";	
	echo "</select></td>
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
				Name:
			</td>
			<td>
				<input type=\"text\" name=\"name\">	
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
				<input type=\"text\" name=\"quota\">
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
				<input type=\"checkbox\" name=\"active\" value=\"1\" checked>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type=\"submit\" value=\"Add mailbox\"></td>
	</table></form>";
	
	
?>