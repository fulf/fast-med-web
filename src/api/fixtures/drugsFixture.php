<?php
	require_once "conn.php";

	$drugsJSON = file_get_contents('../assets/fixtures/drugs.json');
	$drugsFixture = json_decode($drugsJSON, true);

	echo "<i>Dropping</i> existing Drugs table.<br/>";
	if(db_query("DROP TABLE IF EXISTS Drugs")) echo "<b>Success!</b><br/><br/>";

	echo "<i>Creating</i> Drugs table.<br/>";
	$query = "CREATE TABLE `Drugs` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `Name` varchar(50) NOT NULL,
		  `RFID` char(12) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
	if(db_query($query)) echo "<b>Success!</b><br/><br/>";

	foreach ($drugsFixture as $id => $drug) {
		echo "<i>Inserting</i> drug ".($id+1).".<br/>";

		$query = "INSERT INTO 
			Drugs(
				Name,
				RFID
			) VALUES(
				'".$drug["Name"]."',
				'".$drug["RFID"]."'
			);";
			if(db_query($query)) echo "<b>Success!</b><br/><br/>";
	}

	echo "Done.<br/>";