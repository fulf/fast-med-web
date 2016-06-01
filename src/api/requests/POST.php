<?php

function bind($string)
{
    return isset($string) ? "'".$string."'" : "NULL";
}

require_once "conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["RequestID"]) || !isset($data["RobotID"]) || !isset($data["Status"]))
    gracefulExit(400, false, "Request data malformed.");

if(!in_array($data["Status"], ["Active", "Paused", "Canceled", "Completed"]))
    gracefulExit(400, false, "Request data malformed.");

if($result = db_query("INSERT INTO 
			ActionLog(
				RequestID,
				RobotID,
				Status
			) VALUES(
				".bind($data["RequestID"]).",
				".bind($data["RobotID"]).",
				".bind($data["Status"])."
			);")) {
    if($result = db_query("SELECT * FROM fastmed_db.ActionLog WHERE ID = LAST_INSERT_ID()"))
        gracefulExit(200, true, mysqli_fetch_assoc($result));
    else
        gracefulExit(400, false, "An error has occurred. Please try again!");
}
else gracefulExit(400, false, "An error has occurred. Please try again!");