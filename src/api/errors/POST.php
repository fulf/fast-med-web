<?php

function bind($string)
{
    return isset($string) ? "'".$string."'" : "NULL";
}

require_once "conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["RequestID"]) || !isset($data["RobotID"]) || !isset($data["Type"]))
    gracefulExit(400, false, "Request data malformed.");

if(!in_array($data["Type"], ["Line", "Bluetooth", "Obstacle", "Patient", "Drug", "Other"]))
    gracefulExit(400, false, "Request data malformed.");

if($result = db_query("INSERT INTO 
			ErrorLog(
				RequestID,
				RobotID,
				Type
			) VALUES(
				".bind($data["RequestID"]).",
				".bind($data["RobotID"]).",
				".bind($data["Type"])."
			);")) {
    if($result = db_query("SELECT * FROM fastmed_db.ErrorLog WHERE ID = LAST_INSERT_ID()"))
        gracefulExit(200, true, mysqli_fetch_assoc($result));
    else
        gracefulExit(400, false, "An error has occurred. Please try again!");
}
else gracefulExit(400, false, "An error has occurred. Please try again!");