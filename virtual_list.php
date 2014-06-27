<?php
session_start();
include("funciones.php");
include("conexiones.php");
conectar_postfixadmin();
if(!isset($_SESSION['username']))
	header("Location:index.php");

	poweradmin_panel();
	
	echo "<h1>Domain list</h1>";
	
	$query=mysql_query("select domain from domain where domain!=\"ALL\" order by domain");
	if (mysql_num_rows($query) == 0)
		die("No domains");
	echo "<ul>";
	while ($res=mysql_fetch_assoc($query)){
		echo "<li><a href=\"virtual_list.php?domain=".$res['domain']."\">".$res['domain']."</a></li>";
	}
	echo "</ul></hr>";
	
	if (isset($_GET['domain']))
		$domain=$_GET['domain'];
	else {
		$query=mysql_query("select domain from domain where domain!=\"ALL\" order by domain");
		$res=mysql_fetch_assoc($query);
		$domain=$res['domain'];
	}
	
	echo "<hr /><h3>Mailboxes</h3>";
	$query=mysql_query($string="select * from mailbox where domain=\"".$domain."\"")or die($string);
	
	if (mysql_num_rows($query) > 0){
		
		
		echo "
			<table border=1>
				<tr>
					<td>
						Email
					</td>
					<td>
						To
					</td>
					<td>
						Name
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
						".$res['username']."
					</td>
					<td>
						Mailbox
					</td>
					<td>
						".$res['name']."
					</td>
					<td>
						".$res['modified']."
					</td>
					<td>
						".($res['active'] == 1? "YES" : "NO")."
					</td>
					
					<td>
						<a href=\"edit_mailbox.php?mailbox=".$res['username']."\">edit</a>
						<a href=\"delete_mailbox.php?mailbox=".$res['username']."\">delete</a>
					</td>
				</tr>";
		}
		echo "</table>";
	}
	else {
		echo "No mailboxes";
	}
?>