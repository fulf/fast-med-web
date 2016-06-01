<?php
	session_start();
	require "translator.php";
	if($_SESSION['login']!='ok')
		header('Location: index.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Fast-Med | <?php t("Dashboard") ?></title>
<!-- Font Awesome style sheet -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<!-- Angular minified JavaScript-->
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
<!-- Angular Material style sheet -->
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">
<!-- Sweet Alert JavaScript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<!-- Sweet Alert style sheet -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<!-- Fast-Med Web Portal style sheet -->
<link rel="stylesheet" href="css/dashboard.css">
</head>

<body ng-app="FastMed">
<md-toolbar ng-if="message" ng-class="message.type">
	<div class="md-toolbar-tools" style="text-align: center;">
		<span flex>{{message.text}}</span>
	</div>
</md-toolbar>
	<md-toolbar ng-controller="toolbarController">
       <div class="md-toolbar-tools">
         <h2>
           <span><i class="fa fa-heartbeat fa-6" aria-hidden="true"></i> <?php t("Fast-Med Dashboard")?></span>
         </h2>
         <span flex></span>
				 <md-button ng-click="addPatient()"><?php t("Add Patient")?> <i class="fa fa-ambulance" aria-hidden="true"></i></md-button>
         <md-button ng-click="logout()"><?php t("Log Out")?> <i class="fa fa-power-off" aria-hidden="true"></i>	</md-button>
       </div>
     </md-toolbar>

<md-content class="md-app" flex ng-controller="tableController">
	<div class="table-container">
		<table class = "table table-hover">
		<thead>
			<th style="text-align: center;" class="col-md-1">#</th>
			<th style="text-align: center;" class="col-md-3"><?php t("First Name")?></th>
			<th style="text-align: center;" class="col-md-3"><?php t("Last Name")?></th>
			<!-- <th>CNP</th> -->
			<th style="text-align: center;" class="col-md-1"><?php t("Age")?></th>
			<th style="text-align: center;" class="col-md-2"><?php t("Diagnostic")?></th>
			<th style="text-align: center;" class="col-md-2"><?php t("Actions")?></th>
		</thead>
		<tbody>
			<tr ng-repeat="(id, patient) in patients">
				<td style="text-align: center;" class="col-md-1">{{ (table.Page - 1) * table.Limit + id + 1 }}</td>
				<td style="text-align: center;" class="col-md-3">{{ patient.FirstName }}</td>
				<td style="text-align: center;" class="col-md-3">{{ patient.LastName }}</td>
				<!-- <td>{{patient.CNP}}</td> -->
				<td style="text-align: center;" class="col-md-1">{{ patient.Age }}</td>
				<td style="text-align: center;" class="col-md-2">{{ patient.Diagnostic || "<?php t("Undiagnosed")?>" }}</td>
				<td style="text-align: center;" class="col-md-2">
					<md-button class="md-icon-button" ng-click="viewPatient(patient)">
						<md-icon><i class="fa fa-eye"></i></md-icon>
					</md-button>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
</md-content>
<nav class="navbar navbar-default" ng-controller="navbarController">
    <div style="float: left;">
        <md-button class="md-icon-button" ng-click="loadPatients(1)" ng-disabled="page==1">
            <md-icon><i class="fa fa-angle-double-left"></i></md-icon>
        </md-button>
        <md-button class="md-icon-button" ng-click="loadPatients(page-1)" ng-disabled="page==1">
            <md-icon><i class="fa fa-angle-left"></i></md-icon>
        </md-button>
        <?php t("Page") ?>
            <input class="form-control page-select" ng-model="page" ng-blur="loadPatients(page)">
        / {{table.Pages}}
        <md-button class="md-icon-button" ng-click="loadPatients(page+1)" ng-disabled="page==table.Pages">
            <md-icon><i class="fa fa-angle-right"></i></md-icon>
        </md-button>
        <md-button class="md-icon-button" ng-click="loadPatients(table.Pages)" ng-disabled="page==table.Pages">
            <md-icon><i class="fa fa-angle-double-right"></i></md-icon>
        </md-button>
    </div>
    <div style="float: right;">
        <input class="form-control page-select" ng-model="limit" ng-blur="loadPatients(1, limit)"> <?php t("per page") ?>
    </div>
</nav>

<!-- Angular Material requires Angular.js Libraries -->
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
<!-- Angular Material Library -->
<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>
<!-- Fast-Med Web Portal Javascript -->
<script src="js/dashboard.js"></script>
<script>lang='<?=$_SESSION['language']?>'</script>
</body>

</html>
