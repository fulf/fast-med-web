<?php

session_start();

$data = json_decode(file_get_contents('php://input'), true);


if(!isset($data['language']) && !in_array($data['language'], ['ro', 'en']))
    gracefulExit(400, false, "Request data malformed.");
else {
    $_SESSION['language'] = $data['language'];
    gracefulExit(200, true, $_SESSION['language']);
}
function gracefulExit($status, $success, $data)
{
    header('Content-Type: application/json');
    http_response_code($status);
    exit(json_encode(array(
        "success"=>$success,
        "data"=>$data
    )));
}