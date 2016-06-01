<?php
require_once "conn.php";

$robotsJSON = file_get_contents('../assets/fixtures/robots.json');
$robotFixture = json_decode($robotsJSON, true);

echo "<i>Dropping</i> existing Robots table.<br/>";
if(db_query("DROP TABLE IF EXISTS Robots")) echo "<b>Success!</b><br/><br/>";

echo "<i>Creating</i> Robots table.<br/>";
$query = "CREATE TABLE `Robots` (
          `ID` int(11) NOT NULL AUTO_INCREMENT,
          `Name` varchar(50) NOT NULL,
          PRIMARY KEY (`ID`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

if(db_query($query)) echo "<b>Success!</b><br/><br/>";

foreach ($robotFixture as $id => $robot) {
    echo "<i>Inserting</i> drug ".($id+1).".<br/>";

    $query = "INSERT INTO 
			Robots(
				Name
			) VALUES(
				'".$robot["Name"]."'
			);";
    if(db_query($query)) echo "<b>Success!</b><br/><br/>";
}

echo "Done.<br/>";