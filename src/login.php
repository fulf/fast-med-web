<?php

	session_start();
	if($_SESSION['login']=='ok')
		header('Location: index.php');

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Fast-Med | Login</title>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
<!-- Angular Material style sheet -->
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">
<!-- Fast-Med Web Portal style sheet -->
<link rel="stylesheet" href="css/login.css"/>
</head>

<body ng-app="FastMed">

<!-- <div> -->
	<md-card class="login-card" ng-cloak>
		<md-card-title>
			<md-card-title-text>
				<center><span class="md-headline">Login...</span></center>
			</md-card-title-text>
		</md-card-title>
		<md-card-content>
			<md-input-container class="md-block">
		        <label>Username</label>
		        <input ng-model="user.name">
		      </md-input-container>
		      <md-input-container class="md-block">
		        <label>Password</label>
		        <input ng-model="user.password">
		      </md-input-container>
		</md-card-content>
		<md-card-actions layout="column" layout-align="start">
			<md-button class="md-raised md-primary login-actions">Login</md-button>
			<md-button>Password recovery</md-button>
		</md-card-actions>
	</md-card>
<!-- </div> -->
	
<!-- Angular Material requires Angular.js Libraries -->
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
<!-- Angular Material Library -->
<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>
<!-- Fast-Med Web Portal Javascript -->
<script src="js/login.js"></script>
</body>

</html>