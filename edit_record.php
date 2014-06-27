<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_poweradmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");
	
if(!isset($_GET['id'])) 
	header("Location: list_zones.php");


	poweradmin_panel();


	$query=mysql_query("select domains.name, domains.id from domains, records where domains.id=records.domain_id and records.id=".$_GET['id']);
	$res=mysql_fetch_assoc($query);
	$zonename=$res['name'];
	$zoneid=$res['id'];
	
if (isset($_POST['name'])){
	mysql_query($string="update records set name=\"".$_POST['name']."\", type=\"".$_POST['type']."\", content=\"".$_POST['content']."\", ttl=".$_POST['ttl'].", prio=".$_POST['priority']."
	where id=".$_GET['id'])or die($string);
	edit_soa($zoneid);
	echo "The record has been updated successfully.";
}

	echo "<h1>Edit record in zone $zonename</h1>";

	$query=mysql_query("select * from records where id=".$_GET['id']);
	$res=mysql_fetch_assoc($query);
	
	echo "<form action=\"edit_record.php?id=".$_GET['id']."\" method=\"post\">
	<table border=1>
		<tr>
			<td>
				Name
			</td>
			<td>
				Type
			</td>
			<td>
				Priority
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
				<input type=\"text\" name=\"name\" value=\"".$res['name']."\">. IN
			</td>
			<td>
				<select name=\"type\">
		         <option ".($res['type'] == "A" ? 'selected ' : '')."value=\"A\">A</option>
		         <option ".($res['type'] == "AAAA" ? 'selected ' : '')."value=\"AAAA\">AAAA</option>
		         <option ".($res['type'] == "CNAME" ? 'selected ' : '')."value=\"CNAME\">CNAME</option>
		         <option ".($res['type'] == "HINFO" ? 'selected ' : '')."value=\"HINFO\">HINFO</option>
		         <option ".($res['type'] == "MX" ? 'selected ' : '')."value=\"MX\">MX</option>
		         <option ".($res['type'] == "NAPTR" ? 'selected ' : '')."value=\"NAPTR\">NAPTR</option>
		         <option ".($res['type'] == "NS" ? 'selected ' : '')."value=\"NS\">NS</option>
		         <option ".($res['type'] == "PTR" ? 'selected ' : '')."value=\"PTR\">PTR</option>
		         <option ".($res['type'] == "SOA" ? 'selected ' : '')."value=\"SOA\">SOA</option>
		         <option ".($res['type'] == "SPF" ? 'selected ' : '')."value=\"SPF\">SPF</option>
		         <option ".($res['type'] == "SRV" ? 'selected ' : '')."value=\"SRV\">SRV</option>
		         <option ".($res['type'] == "SSHFP" ? 'selected ' : '')."value=\"SSHFP\">SSHFP</option>
		         <option ".($res['type'] == "TXT" ? 'selected ' : '')."value=\"TXT\">TXT</option>
		         <option ".($res['type'] == "RP" ? 'selected ' : '')."value=\"RP\">RP</option>
			</select>
			</td>
			<td>
				<input type=\"text\" name=\"priority\" value=\"".$res['prio']."\">
			</td>
			<td>
				<input type=\"text\" name=\"content\" value=\"".$res['content']."\">
			</td>
			<td>
				<input type=\"text\" name=\"ttl\" value=\"".$res['ttl']."\">
			</td>
		</tr>
	</table>
	<input type=\"submit\" name=\"commit\" value=\"Commit changes\">
	<input type=\"reset\" name=\"reset\" value=\"Reset changes\">
	</form>
	";
?>