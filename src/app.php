<?php

	session_start();
	if($_SESSION['login']!='ok')
		header('Location: index.php');

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Fast-Med | Login</title>
<!-- Font Awesome style sheet -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
<!-- Angular Material style sheet -->
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">
<!-- Fast-Med Web Portal style sheet -->
</head>

<body ng-app="FastMed">

<md-content class="md-app" ng-controller="dashboardController">

	<md-toolbar>
       <div class="md-toolbar-tools">
         <h2>
           <span>Fast-Med Dashboard</span>
         </h2>
         <span flex></span>
				 <md-button>Add Patient <i class="fa fa-ambulance" aria-hidden="true"></i></md-button>
         <md-button ng-click="logout()">Log Out <i class="fa fa-power-off" aria-hidden="true"></i>	</md-button>
       </div>
     </md-toolbar>



<table class = "table table-hover">
<thead>
	<th style="text-align: center;"class="col-md-1">#</th>
	<th style="text-align: center;" class="col-md-3">First Name</th>
	<th style="text-align: center;" class="col-md-3">Last Name</th>
	<!-- <th>CNP</th> -->
	<th style="text-align: center;" class="col-md-1">Age</th>
	<th style="text-align: center;" class="col-md-2">Diagnostic</th>
	<th style="text-align: center;" class="col-md-2">Actions</th>
</thead>
<tbody>
	<tr ng-repeat="(id, patient) in patients">
		<td style="text-align: center;">{{id+1}}</td>
		<td style="text-align: center;">{{patient.FirstName}}</td>
		<td style="text-align: center;">{{patient.LastName}}</td>
		<!-- <td>{{patient.CNP}}</td> -->
		<td style="text-align: center;">{{patient.Age}}</td>
		<td style="text-align: center;">{{patient.Diagnostic || "Undiagnosed"}}</td>
		<td style="text-align: center;"><md-button class="md-icon-button " aria-label="Settings">
		<md-icon <i style="color: green;"class="fa fa-eye" aria-hidden="true"></i></md-icon>
		</md-button>
		</td>

		</tr>
</tbody>
</table>
</md-content>


<!-- Angular Material requires Angular.js Libraries -->
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
<!-- Angular Material Library -->
<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>
<!-- Fast-Med Web Portal Javascript -->
<script src="js/dashboard.js"></script>
</body>

</html>
