<?php

	echo "Running fixtures!<br/><br/>";
	include "fixtures/actionLogFixture.php";
	include "fixtures/bedsFixture.php";
	include "fixtures/drugsFixture.php";
	include "fixtures/errorLogFixture.php";
	include "fixtures/patientsFixture.php";
	include "fixtures/requestsFixture.php";
	include "fixtures/robotsFixture.php";
	include "fixtures/usersFixture.php";

	echo "Finished fixtures!<br/><br/>";

function gracefulExit($status, $success, $data)
{
	header('Content-Type: application/json');
	http_response_code($status);
	exit(json_encode(array(
		"success"=>$success,
		"data"=>$data
	)));
}