<?php

session_start();

if($_SERVER['REQUEST_METHOD'] == 'DELETE')
	require 'authenticate/DELETE.php';
else if($_SERVER['REQUEST_METHOD'] == 'POST')
	require 'authenticate/POST.php';

function gracefulExit($status, $success, $data)
{
	header('Content-Type: application/json');
	http_response_code($status);
	exit(json_encode(array(
		"success"=>$success,
		"data"=>$data
	)));
}