<?php

function bind($string)
{
    return isset($string) ? "'".$string."'" : "NULL";
}

require_once "conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["Name"]) || !isset($data["RFID"]))
    gracefulExit(400, false, "Request data malformed.");

if($result = db_query("INSERT INTO 
			Drugs(
				Name,
				RFID
			) VALUES(
				".bind($data["Name"]).",
				".bind($data["RFID"])."
			);")) {
    if($result = db_query("SELECT * FROM fastmed_db.Drugs WHERE ID = LAST_INSERT_ID()"))
        gracefulExit(200, true, mysqli_fetch_assoc($result));
    else
        gracefulExit(400, false, "An error has occured. Please try again!");
}
else gracefulExit(400, false, "An error has occured. Please try again!");