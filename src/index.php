<?php
	session_start();
	if($_SESSION['login']!='ok')
		require 'login.php';
	else
		require 'app.php';
?>