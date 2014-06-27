<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_poweradmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

	poweradmin_panel();
	echo "<h1>List zones</h1>";
	/*$query=mysql_query($string = "select domains.id, domains.name, domains.type, COUNT(*) as records, users.fullname 
		from domains, zones, users, records
		where
		domains.id=zones.domain_id AND
		zones.owner=users.id AND
		records.domain_id=domains.id
		group by records.domain_id
	");*/
	$query=mysql_query("SELECT domains.id,
                        domains.name,
                        domains.type,
                        Record_Count.count_records as records,
                        users.fullname
                        FROM domains
                        LEFT JOIN zones ON domains.id=zones.domain_id
                        LEFT JOIN users ON users.id=zones.owner
                        LEFT JOIN (
                                SELECT COUNT(domain_id) AS count_records, domain_id FROM records GROUP BY domain_id
                        ) Record_Count ON Record_Count.domain_id=domains.id
                        WHERE 1=1
                        GROUP BY domains.name, domains.id, domains.type, Record_Count.count_records
                        ORDER BY domains.name
	");
	if (mysql_num_rows($query) > 0)
	{
	echo "
		<table border=1>
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
				Records
				</td>
				<td>
				Owner
				</td>
			</tr>		
		";
	while($res=mysql_fetch_assoc($query))
	{
		echo "<tr>
			<td>
				<a href=\"edit_zone.php?id=".$res['id']."\">Edit</a>
				<a href=\"delete_zone.php?id=".$res['id']."\">Delete</a>
			</td>
			<td>
				".$res['name']."
			</td>
			<td>
				".$res['type']."
			</td>
			<td>
				".($res['records'] ? $res['records'] : 0)."
			</td>
			<td>
				".$res['fullname']."
			</td>
		</tr>";
	}
	echo"</table>";
	}
	else {
		echo "No mailbox :(";
	}
?>