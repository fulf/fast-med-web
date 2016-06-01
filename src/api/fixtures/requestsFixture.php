<?php
require_once "conn.php";

echo "<i>Dropping</i> existing Requests table.<br/>";
if(db_query("DROP TABLE IF EXISTS Requests")) echo "<b>Success!</b><br/><br/>";

echo "<i>Creating</i> Requests table.<br/>";
$query = "CREATE TABLE `Requests` (
          `ID` int(11) NOT NULL AUTO_INCREMENT,
          `Type` varchar(50) NOT NULL,
          `DrugID` int(11) DEFAULT NULL,
          `PatientID` int(11) DEFAULT NULL,
          `Timestamp` datetime NOT NULL,
          `UserID` int(11) NOT NULL,
          `Acknowledged` varchar(10) NOT NULL DEFAULT 'No',
          `RobotID` int(11) DEFAULT NULL,
          PRIMARY KEY (`ID`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
if(db_query($query)) echo "<b>Success!</b><br/><br/>";

echo "Done.<br/>";