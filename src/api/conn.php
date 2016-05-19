<?php
	function db_query($query)
	{
		$conn = mysqli_connect("db.fastmed.soringuga.ro", "fastmed", "fastmed123", "fastmed_db");

		if (!$conn) {
		    echo "Error: Unable to connect to MySQL." . PHP_EOL;
		    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		    exit;
		}

		if (!$rs = mysqli_query($conn, $query))
		{
			echo "<b>Error:</b> ".mysqli_error($conn)."<br/><br/>";
			return false;
		}
		return $rs;
	}
?>