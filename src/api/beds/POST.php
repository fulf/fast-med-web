<?php

function bind($string)
{
    return isset($string) ? "'".$string."'" : "NULL";
}

require_once "conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["Room"]) || !isset($data["RFID"]))
    gracefulExit(400, false, "Request data malformed.");

if($result = db_query("INSERT INTO 
			Beds(
				Room,
				RFID
			) VALUES(
				".bind($data["Room"]).",
				".bind($data["RFID"])."
			);")) {
    if($result = db_query("SELECT * FROM fastmed_db.Beds WHERE ID = LAST_INSERT_ID()"))
        gracefulExit(200, true, mysqli_fetch_assoc($result));
    else
        gracefulExit(400, false, "An error has occurred. Please try again!");
}
else gracefulExit(400, false, "An error has occurred. Please try again!");