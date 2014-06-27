<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_poweradmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

	poweradmin_panel();
	
if(!isset($_GET['id'])) 
	die("Error: Invalid or unexpected input given.");

	$query=mysql_query("select name from domains where id=".$_GET['id']);
	$res=mysql_fetch_assoc($query);
	$zonename=$res['name'];

if (isset($_POST['name'])){
	$string="insert into records (domain_id, name, type, content, ttl, prio) values (".$_GET['id'].", \"".$_POST[ 'name'].".".$zonename."\", \"".$_POST['type']."\", \"".$_POST['content']."\", ".$_POST['ttl'].", ".$_POST['priority'].")";
	mysql_query($string)or die ($string);
	edit_soa($_GET['id']);
	echo "The record was successfully added.";
	
}



	echo "<h1>Edit zone $zonename</h1>";
	
	echo "	<table border=1>
		<tr>
			<td>
			</td>
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
				Priority
			</td>
			<td>
				TTL
			</td>
		</tr>";

	$query=mysql_query("select id, name, type, content, ttl, prio from records where domain_id=".$_GET['id']);
	while ($res=mysql_fetch_assoc($query)) {
		echo "<tr>
			<td>
				<a href=\"edit_record.php?id=".$res['id']."\">Edit</a>
				<a href=\"delete_record.php?id=".$res['id']."\">Delete</a>
			</td>
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
				".$res['prio']."
			</td>
			<td>
				".$res['ttl']."
			</td>
		</tr>";
	}
		echo "</table><br />";

	
	echo "<form action=\"edit_zone.php?id=".$_GET['id']."\" method=\"post\">
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
				Priority
			</td>
			<td>
				TTL
			</td>
		</tr>
		<tr>
			<td>
				<input type=\"text\" name=\"name\">.$zonename IN
			</td>
			<td>
				<select name=\"type\">
		         <option selected=\"\" value=\"A\">A</option>
		         <option value=\"AAAA\">AAAA</option>
		         <option value=\"CNAME\">CNAME</option>
		         <option value=\"HINFO\">HINFO</option>
		         <option value=\"MX\">MX</option>
		         <option value=\"NAPTR\">NAPTR</option>
		         <option value=\"NS\">NS</option>
		         <option value=\"PTR\">PTR</option>
		         <option value=\"SOA\">SOA</option>
		         <option value=\"SPF\">SPF</option>
		         <option value=\"SRV\">SRV</option>
		         <option value=\"SSHFP\">SSHFP</option>
		         <option value=\"TXT\">TXT</option>
		         <option value=\"RP\">RP</option>
			</select>
			</td>
			<td>
				<input type=\"text\" name=\"content\">
			</td>
			<td>
				<input type=\"text\" name=\"priority\">
			</td>
			<td>
				<input type=\"text\" name=\"ttl\">
			</td>
		</tr>
	</table>
	<input type=\"submit\" name=\"commit\" value=\"Add record\">
	</form>
	";
?>