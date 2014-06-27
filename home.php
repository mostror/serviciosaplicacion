<?php
session_start();
include("funciones.php");
include("conexiones.php");
if(!isset($_SESSION['username']))
	header("Location:index.php");

	poweradmin_panel();
	

?>