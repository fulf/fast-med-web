<?php
require_once "conn.php";

echo "<i>Dropping</i> existing ActionLog table.<br/>";
if(db_query("DROP TABLE IF EXISTS ActionLog")) echo "<b>Success!</b><br/><br/>";

echo "<i>Creating</i> ActionLog table.<br/>";
$query = "CREATE TABLE `ActionLog` (
          `ID` int(11) NOT NULL AUTO_INCREMENT,
          `RequestID` int(11) NOT NULL,
          `RobotID` int(11) NOT NULL,
          `Status` varchar(50) NOT NULL,
          `Timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`ID`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
if(db_query($query)) echo "<b>Success!</b><br/><br/>";

echo "Done.<br/>";