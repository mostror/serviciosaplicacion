<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_poweradmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

	poweradmin_panel();
		if (isset($_POST['zonename'])){
			$query=mysql_query("select * from domains where name=\"".$_POST['zonename']."\"");
	
			if (mysql_num_rows($query) > 0)
				echo "Error: ".$_POST['zonename']." failed - There is already a zone with this name";
			elseif (!preg_match("^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$^", $_POST['zonename'])) {
				echo "Error: ".$_POST['zonename']." failed - Invalid hostname.";
			}
			else {
				mysql_query($string="insert into domains (name, master, type) values (\"".$_POST['zonename']."\", \"".$_POST['slave_master']."\", \"SLAVE\")") or die($string);
				$zoneid=mysql_insert_id();

				mysql_query("insert into zones (domain_id, owner) values (".$zoneid.", ".$_POST['owner'].")");
				echo "<a href=edit_zone.php?id=$zoneid>Zone has been added successfully.</a>";
			}


	}

	$query=mysql_query("select id, fullname from users");
	echo "<form action=\"add_slave_zone.php\" method=\"post\">
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
				IP of master NS:
			</td>
			<td>
				 <input type=\"text\" name=\"slave_master\">
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
			<td></td>
			<td><input type=\"submit\" value=\"Add zone\"></td>
	</table></form>";
	
?>