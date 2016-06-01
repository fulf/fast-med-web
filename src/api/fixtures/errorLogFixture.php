<?php
require_once "conn.php";

echo "<i>Dropping</i> existing ErrorLog table.<br/>";
if(db_query("DROP TABLE IF EXISTS ErrorLog")) echo "<b>Success!</b><br/><br/>";

echo "<i>Creating</i> ErrorLog table.<br/>";
$query = "CREATE TABLE `ErrorLog` (
          `ID` int(11) NOT NULL AUTO_INCREMENT,
          `ActionID` int(11) NOT NULL,
          `RobotID` int(11) NOT NULL,
          `Type` varchar(50) NOT NULL,
          `Timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`ID`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
if(db_query($query)) echo "<b>Success!</b><br/><br/>";

echo "Done.<br/>";