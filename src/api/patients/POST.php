<?php

function bind($string)
{
    return isset($string) ? "'".$string."', " : "NULL, ";
}

require_once "conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["CNP"]) || !isset($data["FirstName"]) || !isset($data["LastName"]) || !isset($data["Age"]) || !isset($data["Address"]) || !isset($data["BedID"]))
    gracefulExit(400, false, "Request data malformed.");

if($result = db_query("INSERT INTO 
			Patients(
				CNP,
				FirstName,
				LastName,
				Age,
				Address,
				Diagnosis,
				BedID
			) VALUES(
				".bind($data["CNP"])."
				".bind($data["FirstName"])."
				".bind($data["LastName"])."
				".bind($data["Age"])."
				".bind($data["Address"])."
				".bind($data["Diagnosis"])."
				".bind($data["BedID"])."
			);")) {
    if($result = db_query("SELECT * FROM fastmed_db.Patients WHERE ID = LAST_INSERT_ID()"))
        gracefulExit(200, true, mysqli_fetch_assoc($result));
    else
        gracefulExit(400, false, "An error has occurred. Please try again!");
}
else gracefulExit(400, false, "An error has occurred. Please try again!");