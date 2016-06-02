<?php

function bind($string)
{
    return isset($string) ? "'".$string."'" : "NULL";
}

require_once "conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["Type"]))
    gracefulExit(400, false, "Request data malformed.");
    
if(!in_array($data["Type"], ["Delivery", "Manual", "Automatic"]))
    gracefulExit(400, false, "Request data malformed.");
else if($data["Type"]=="Delivery" && (!isset($data["DrugID"]) || !isset($data["BedID"])))
    gracefulExit(400, false, "Request data malformed.");
else if(in_array($data["Type"], ["Manual", "Automatic"]) && !isset($data["RobotID"]))
    gracefulExit(400, false, "Request data malformed.");

if($result = db_query("INSERT INTO 
			Requests(
				Type,
				DrugID,
				BedID,
				RobotID
			) VALUES(
				".bind($data["Type"]).",
				".bind($data["DrugID"]).",
				".bind($data["BedID"]).",
				".bind($data["RobotID"])."
			);")) {
    if($result = db_query("SELECT * FROM fastmed_db.Requests WHERE ID = (SELECT MAX(ID) FROM Requests)"))
        gracefulExit(200, true, mysqli_fetch_assoc($result));
    else
        gracefulExit(400, false, "An error has occurred. Please try again!");
}
else gracefulExit(400, false, "An error has occurred. Please try again!");