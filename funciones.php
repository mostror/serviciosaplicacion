<?php 
function poweradmin_panel(){
	echo"
		<ul>
			<li>DNS
				<ul>
					<li><a href=\"list_zones.php\">List zones</a></li>
					<li><a href=\"add_master_zone.php\">Add master zone</a></li>
					<li><a href=\"add_slave_zone.php\">Add slave zone</a></li>
				</ul>
			</li>
			<li>Mail
				<ul>
					<li><a href=\"list_domains.php\">List domains</a></li>
					<li><a href=\"add_domain.php\">New Domain</a></li>
					<li><a href=\"virtual_list.php\">Mailbox lists</a></li>
					<li><a href=\"add_mailbox.php\">Add mailbox</a></li>
				</ul>
			</li>
			<li>
				<a href=\"logout.php\">Logout</a>
			</li>
		</ul>
		<hr />
	";
}
function edit_soa($zone_id){
	$query=mysql_query("select content from records where domain_id=$zone_id and type=\"SOA\"")or die("edit SOA failure");
	$res=mysql_fetch_assoc($query);
	
	$exp=explode(" ", $res['content']);
	$date=substr($exp[2], 0, 8);
	$number=substr($exp[2], 8, 4);
	
	if (date("Ymd") == $date)
	{
		$exp[2]=$date;
		if ($number<9)
			$exp[2].="0";
		$exp[2].=($number+1);
	}
	else {
		$exp[2]=date("Ymd")."00";
	}
	$content=implode(" ", $exp);
	
	mysql_query($string="update records set content=\"$content\" where domain_id=$zone_id and type=\"SOA\"")or die($string);
}
?>