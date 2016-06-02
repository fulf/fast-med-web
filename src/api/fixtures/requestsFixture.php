<?php

function bind($string)
{
    return isset($string) ? "'".$string."'" : "NULL";
}

require_once "conn.php";

$requestsJSON = file_get_contents('../assets/fixtures/requests.json');
$requestsFixture = json_decode($requestsJSON, true);

echo "<i>Dropping</i> existing Requests table.<br/>";
if(db_query("DROP TABLE IF EXISTS Requests")) echo "<b>Success!</b><br/><br/>";

echo "<i>Creating</i> Requests table.<br/>";
$query = "CREATE TABLE `Requests` (
          `ID` int(11) NOT NULL AUTO_INCREMENT,
          `Type` varchar(50) NOT NULL,
          `DrugID` int(11) DEFAULT NULL,
          `BedID` int(11) DEFAULT NULL,
          `Timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `UserID` int(11) NOT NULL,
          `Acknowledged` varchar(10) NOT NULL DEFAULT 'No',
          `RobotID` int(11) DEFAULT NULL,
          PRIMARY KEY (`ID`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
if(db_query($query)) echo "<b>Success!</b><br/><br/>";

foreach ($requestsFixture as $id => $request) {
    echo "<i>Inserting</i> patient ".($id+1).".<br/>";

    $query = "INSERT INTO 
			Requests(
				Type,
				DrugID,
				BedID,
				UserID,
				Acknowledged,
				RobotID
			) VALUES(
				".bind($request["Type"]).",
				".bind($request["DrugID"]).",
				".bind($request["BedID"]).",
				".bind($request["UserID"]).",
				".bind($request["Acknowledged"]).",
				".bind($request["RobotID"])."
			);";
    if(db_query($query)) echo "<b>Success!</b><br/><br/>";
}

echo "Done.<br/>";