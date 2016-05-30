<?php
	require_once "conn.php";

	$patientsJSON = file_get_contents('../assets/fixtures/patients.json');
	$patientsFixture = json_decode($patientsJSON, true);

	echo "<i>Dropping</i> existing Patients table.<br/>";
	if(db_query("DROP TABLE IF EXISTS Patients")) echo "<b>Success!</b><br/><br/>";

	echo "<i>Creating</i> Patients table.<br/>";
	$query = "CREATE TABLE `Patients` (
		  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `CNP` char(13) NOT NULL DEFAULT '',
		  `FirstName` varchar(50) NOT NULL DEFAULT '',
		  `LastName` varchar(50) NOT NULL DEFAULT '',
		  `Age` int(11) NOT NULL,
		  `Address` varchar(255) NOT NULL DEFAULT '',
		  `Hospitalized` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `Released` datetime DEFAULT NULL,
		  `Diagnosis` varchar(50) DEFAULT NULL,
		  `BedID` int(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
	if(db_query($query)) echo "<b>Success!</b><br/><br/>";

	foreach ($patientsFixture as $id => $patient) {
		echo "<i>Inserting</i> patient ".($id+1).".<br/>";

		$query = "INSERT INTO 
			Patients(
				CNP,
				FirstName,
				LastName,
				Age,
				Address,
				BedID
			) VALUES(
				'".$patient["CNP"]."',
				'".$patient["FirstName"]."',
				'".$patient["LastName"]."',
				'".$patient["Age"]."',
				'".$patient["Address"]."',
				'".$patient["BedID"]."'
			);";
			if(db_query($query)) echo "<b>Success!</b><br/><br/>";
	}

	echo "Done.<br/>";