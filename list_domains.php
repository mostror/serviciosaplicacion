<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_postfixadmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

	poweradmin_panel();

	echo "<h1>Domains</h1>";
	
	$query = mysql_query($string = " SELECT domain,description,aliases,coalesce(__alias_count,0) - coalesce(__mailbox_count,0)  as alias_count,mailboxes,coalesce(__mailbox_count,0) as mailbox_count,round(coalesce(__total_quota/1024000,0)) as total_quota,quota,CASE backupmx WHEN '1' THEN '1'    WHEN '0' THEN '0'   END as backupmx,CASE backupmx WHEN '1' THEN 'YES' WHEN '0' THEN 'NO' END as _backupmx,CASE active WHEN '1' THEN '1'    WHEN '0' THEN '0'   END as active,CASE active WHEN '1' THEN 'YES' WHEN '0' THEN 'NO' END as _active,DATE_FORMAT(created, '%Y-%m-%d') AS created, created AS _created,DATE_FORMAT(modified, '%Y-%m-%d') AS modified, modified AS _modified FROM domain  left join ( select count(*) as __alias_count, domain as __alias_domain from alias group by domain) as __alias on domain = __alias_domain
 left join ( select count(*) as __mailbox_count, sum(quota) as __total_quota, domain as __mailbox_domain from mailbox group by domain) as __mailbox on domain = __mailbox_domain
  WHERE ( 1=1 ) AND domain != \"ALL\"ORDER BY domain");

	if (mysql_num_rows($query) == 0)
		echo "No domains";
	else {
		echo "
		<table border=1>
			<tr>
				<td>
					Domain
				</td>
				<td>
					Description
				</td>
				<td>
					Aliases
				</td>
				<td>
					Mailboxes
				</td>
				<td>
					Domain Quota (Mb)
				</td>
				<td>
					Backup MX
				</td>
				<td>
					Last modified
				</td>
				<td>
					Active
				</td>
				<td>
				</td>
			</tr>		
		";
		while($res=mysql_fetch_assoc($query))
		{
			echo "<tr>
				<td>
					".$res['domain']."
				</td>
				<td>
					".$res['description']."
				</td>
				<td>
					".$res['alias_count']." / ".$res['aliases']." 
				</td>
				<td>
					".$res['mailbox_count']." / ".$res['mailboxes']."
				</td>
				<td>
					".$res['total_quota']." / ".$res['quota']."
				</td>
				<td>
					".$res['_backupmx']."
				</td>
				<td>
					".$res['modified']."
				</td>
				<td>
					".$res['_active']."
				</td>
				<td>
					<a href=\"edit_domain.php?domain=".$res['domain']."\">Edit</a>
					<a href=\"delete_domain.php?domain=".$res['domain']."\">Delete</a>
				</td>
			</tr>";
		}
		echo"</table>";
	}
?>