<?php
	require_once "conn.php";

	$usersJSON = file_get_contents('../assets/fixtures/users.json');
	$usersFixture = json_decode($usersJSON, true);

	echo "<i>Dropping</i> existing Users table.<br/>";
	if(db_query("DROP TABLE IF EXISTS Users")) echo "<b>Success!</b><br/><br/>";

	echo "<i>Creating</i> Users table.<br/>";
	$query = "CREATE TABLE `Users` (
		  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `Username` varchar(50) NOT NULL DEFAULT '',
		  `FirstName` varchar(50) NOT NULL DEFAULT '',
		  `LastName` varchar(50) NOT NULL DEFAULT '',
		  `Email` varchar(255) NOT NULL DEFAULT '',
		  `Password` char(60) NOT NULL DEFAULT '',
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
	if(db_query($query)) echo "<b>Success!</b><br/><br/>";

	foreach ($usersFixture as $id => $user) {
		echo "<i>Inserting</i> user ".($id+1).".<br/>";

		$query = "INSERT INTO 
			Users(
				Username,
				FirstName,
				LastName,
				Email,
				Password
			) VALUES(
				'".$user["UserName"]."',
				'".$user["FirstName"]."',
				'".$user["LastName"]."',
				'".$user["Email"]."',
				'".$user["Password"]."'
			);";
			if(db_query($query)) echo "<b>Success!</b><br/><br/>";
	}

	echo "Done.<br/>";
?>