<?php

	session_start();
	require "translator.php";
	if(!isset($_SESSION['language']))
		$_SESSION['language'] = "en";
	if($_SESSION['login']=='ok')
		header('Location: index.php');

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Fast-Med | <?php t("Login") ?></title>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
<!-- Angular Material style sheet -->
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">
<!-- Font Awesome style sheet -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<!-- Bootstrap style sheet -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- Flag Icon CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/2.3.1/css/flag-icon.min.css">
<!-- Fast-Med Web Portal style sheet -->
<link rel="stylesheet" href="css/login.css"/>
</head>

<body ng-app="FastMed">

<!-- <div> -->
<md-content class="md-app">
	<md-card class="login-card" ng-cloak ng-controller="loginController">
		<md-card-title>
			<md-card-title-text>
				<div style="text-align: center;"><span class="md-headline"><?php t("Login")?></span></div>
			</md-card-title-text>
		</md-card-title>
		<md-card-content>
			<div layout="row" layout-sm="column" layout-align="space-around">
				<div class="md-toolbar-tools" ng-if="state == 'error'" style="background-color: rgb(255,87,34); color: white">
					<h2 class="md-flex"><?php t("Wrong username or password") ?>.</h2>
				</div>

				<div class="md-toolbar-tools" ng-if="state == 'success'" style="background-color: rgb(76,175,80); color: white">
					<h2 class="md-flex"><?php t("Logged in successfully") ?>!</h2>
				</div>

				<md-progress-circular ng-show="state == 'loading'" md-mode="indeterminate"></md-progress-circular>
			</div>
			<form name="loginForm">
				<md-input-container class="md-block">
					<label><?php t("Username") ?></label>
					<input required md-no-asterisk name="username" ng-model="user.username"/>
					<div ng-messages="loginForm.username.$error">
						<div ng-message="required"><?php t("Username cannot be empty") ?>.</div>
					</div>
				  </md-input-container>
				  <md-input-container class="md-block">
					<label><?php t("Password") ?></label>
					<input required md-no-asterisk name="password" type="password" ng-model="user.password"/>
					  <div ng-messages="loginForm.password.$error">
						  <div ng-message="required"><?php t("Password cannot be empty") ?>.</div>
					  </div>
				  </md-input-container>
			</form>
		</md-card-content>
		<md-card-actions layout="column" layout-align="start">
			<md-button id="loginButton" class="md-raised md-primary login-actions" ng-disabled="!loginForm.$valid" ng-click="login()"><?php t("Login") ?></md-button>
			<md-button id="recoveryButton" ng-disabled="true"><?php t("Password recovery") ?></md-button>
			<md-button ng-click="runFixture()"><?php t("Run Fixtures") ?></md-button>
			<div style="text-align: center">
				<md-button ng-click="setLanguage('en')" ng-disabled="'<?=$_SESSION['language']?>'=='en'" class="md-icon-button <?=$_SESSION['language']=='en' ? 'selected' : ''?>"><span class="flag-icon flag-icon-gb"></span></md-button>
				<md-button ng-click="setLanguage('ro')" ng-disabled="'<?=$_SESSION['language']?>'=='ro'" class="md-icon-button <?=$_SESSION['language']=='ro' ? 'selected' : ''?>"><span class="flag-icon flag-icon-ro"></span></md-button>
			</div>
		</md-card-actions>
	</md-card>
</md-content>
<!-- </div> -->

<!-- Angular Material requires Angular.js Libraries -->
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
<!-- Angular Material Library -->
<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
<!-- Fast-Med Web Portal Javascript -->
<script src="js/login.js"></script>
</body>
</html>
