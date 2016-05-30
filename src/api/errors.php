<?php

session_start();

if($_SESSION['login'] != 'ok')
    gracefulExit(401, false, "Unauthorised request. This incident has been reported.");

if($_SERVER['REQUEST_METHOD'] == 'GET')
    require 'errors/GET.php';
else if($_SERVER['REQUEST_METHOD'] == 'POST')
    require 'errors/POST.php';

function gracefulExit($status, $success, $data)
{
    header('Content-Type: application/json');
    http_response_code($status);
    exit(json_encode(array(
        "success"=>$success,
        "data"=>$data
    )));
}