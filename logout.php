<?php
	session_start(); 



	//TODO: Delete username out of database here 

	session_destroy(); 
	header('Location: index.php');
?>