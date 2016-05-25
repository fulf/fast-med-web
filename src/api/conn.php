<?php
	function db_query($query)
	{
		$conn = mysqli_connect("db.fastmed.soringuga.ro", "fastmed", "fastmed123", "fastmed_db");

		if (!$conn)
            gracefulExit(400, false, "Error: " . mysqli_connect_errno() . ": " .  mysqli_connect_error());

		if (!$rs = mysqli_query($conn, $query))
			gracefulExit(400, false, mysqli_error($conn));

        return $rs;
	}