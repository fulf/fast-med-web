<?php
	require_once "conn.php";

	$bedsJSON = file_get_contents('../assets/fixtures/beds.json');
	$bedsFixture = json_decode($bedsJSON, true);

	echo "<i>Dropping</i> existing Beds table.<br/>";
	if(db_query("DROP TABLE IF EXISTS Beds")) echo "<b>Success!</b><br/><br/>";

	echo "<i>Creating</i> Beds table.<br/>";
	$query = "CREATE TABLE `Beds` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `Room` varchar(50) NOT NULL,
		  `RFID` char(12) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
	if(db_query($query)) echo "<b>Success!</b><br/><br/>";

	foreach ($bedsFixture as $id => $bed) {
		echo "<i>Inserting</i> drug ".($id+1).".<br/>";

		$query = "INSERT INTO 
			Drugs(
				Room,
				RFID
			) VALUES(
				'".$bed["Room"]."',
				'".$bed["RFID"]."'
			);";
			if(db_query($query)) echo "<b>Success!</b><br/><br/>";
	}

	echo "Done.<br/>";
?>