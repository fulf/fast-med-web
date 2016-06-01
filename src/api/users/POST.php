<?php

function bind($string)
{
    return isset($string) ? "'".$string."'" : "NULL";
}

require_once "conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["Username"]) || !isset($data["FirstName"]) || !isset($data["LastName"]) || !isset($data["Email"]) || !isset($data["Password"]))
    gracefulExit(400, false, "Request data malformed.");

if($result = db_query("INSERT INTO 
			Users(
				Username,
				FirstName,
				LastName,
				Email,
				Password
			) VALUES(
				".bind($data["Username"]).",
				".bind($data["FirstName"]).",
				".bind($data["LastName"]).",
				".bind($data["Email"]).",
				".password_hash(bind($data["Password"]), PASSWORD_BCRYPT)."
			);")) {
    if($result = db_query("SELECT * FROM fastmed_db.Users WHERE ID = LAST_INSERT_ID()"))
        gracefulExit(200, true, mysqli_fetch_assoc($result));
    else
        gracefulExit(400, false, "An error has occurred. Please try again!");
}
else gracefulExit(400, false, "An error has occurred. Please try again!");