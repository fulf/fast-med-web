<?php
require_once "conn.php";

echo "<i>Dropping</i> existing Robots table.<br/>";
if(db_query("DROP TABLE IF EXISTS Robots")) echo "<b>Success!</b><br/><br/>";

echo "<i>Creating</i> Robots table.<br/>";
$query = "CREATE TABLE `Robots` (
          `ID` int(11) NOT NULL AUTO_INCREMENT,
          `Name` varchar(50) NOT NULL,
          PRIMARY KEY (`ID`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

if(db_query($query)) echo "<b>Success!</b><br/><br/>";

echo "Done.<br/>";