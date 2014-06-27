<?php
session_start();
if(isset($_SESSION['username']))
header("Location:home.php");

?>

Login:
<form name="formLogin" method="post" action="login.php">
<table>
	<tr>
		<td>
		<p>Username</p>
		</td>
		<td><input type="text" name="username" id="username"></td>
	</tr>
	<tr>
		<td>
		<p>Password</p>
		</td>
		<td><input type="password" name="password"></td>
	</tr>
	<tr>
		<td></td>
		<input type="hidden" name="action" value="login">
		<td><input type="submit" value="Login" id="buttonLogin"></td>
	</tr>
	
</table>
</form>
