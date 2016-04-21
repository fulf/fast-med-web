<?php

	session_start();
	if($_SESSION['login']!='ok')
		header('Location: index.php');

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Fast-Med | Index</title>
</head>

<body>
Content of the document......
</body>

</html>