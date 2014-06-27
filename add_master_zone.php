<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_poweradmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

	poweradmin_panel();
	echo "<h1>Add master zone</h1>";
		if (isset($_POST['zonename'])){
			$query=mysql_query("select * from domains where name=\"".$_POST['zonename']."\"");
	
			if (mysql_num_rows($query) > 0)
				echo "Error: ".$_POST['zonename']." failed - There is already a zone with this name";
			elseif (!preg_match("^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$^", $_POST['zonename'])) {
				echo "Error: ".$_POST['zonename']." failed - Invalid hostname.";
			}
			else {
				mysql_query($string="insert into domains (name, type) values (\"".$_POST['zonename']."\", \"".$_POST['type']."\")") or die($string);
				$zoneid=mysql_insert_id();

				mysql_query("insert into zones (domain_id, owner) values (".$zoneid.", ".$_POST['owner'].")");
				mysql_query($string ="insert into records (domain_id, name, type, content, ttl, prio) values (".$zoneid.", \"".$_POST['zonename']."\", \"SOA\", \"ns1.".$_POST['zonename']." hostmaster.".$_POST['zonename']." ".date("Ymd")."00 28800 7200 604800 86400\", 3600, 0)") or die ($string);
				
				echo $_POST['zonename']." - Zone has been added successfully.";
				echo "<hr />";
			}
	}

	$query=mysql_query("select id, fullname from users");
	echo "<form action=\"add_master_zone.php\" method=\"post\">
	<table border=1>
		<tr>
			<td>
				Zone name:
			</td>
			<td>
				 <input type=\"text\" name=\"zonename\">
			</td>
		</tr>
		<tr>
			<td>
				Owner:
			</td>
			<td><select name=\"owner\">";
				 while ($res=mysql_fetch_assoc($query)){
			 		echo "<option value=".$res['id'].">".$res['fullname']."</option>";
				 }
			echo "</select></td>
		</tr>
		<tr>
			<td>
				Type:
			</td>
			<td>
				<select name=\"type\">
					<option value=\"MASTER\">Master</option>
					<option value=\"NATIVE\">Native</option>
			</select></td>
		</tr>
		<tr>
			<td></td>
			<td><input type=\"submit\" value=\"Add zone\"></td>
	</table></form>";
	
?>