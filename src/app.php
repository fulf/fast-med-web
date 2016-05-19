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
<link rel="stylesheet" href="css/login.css"/>
</head>

<body ng-app="FastMed">

<md-content class="md-app">

	<md-toolbar>
       <div class="md-toolbar-tools">
         <h2>
           <span>Fast-Med Dashboard</span>
         </h2>
         <span flex></span>
         <md-button>Add Patient</md-button>
       </div>
     </md-toolbar>



<table class = "table table-hover " ng-controller="patientTable">
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
<script>

angular.module('FastMed', ['ngMaterial'])
.controller('patientTable', function($scope){
	$scope.patients = [{"FirstName":"Denis","LastName":"Boboc","CNP":"5880208067263","Age":23,"Diagnostic":"Gripa","Address":"Splaiul Piersicului 8, Mun. Sulina, Timi\u0219, CP 482211","BedID":52},{"FirstName":"Adina","LastName":"Cosma","CNP":"6821213522554","Age":21,"Address":"Splaiul Clo\u0219ca nr. 1B, bl. A, ap. 98, R\u00e2\u0219nov, D\u00e2mbovi\u021ba, CP 041595","BedID":95},{"FirstName":"Geta","LastName":"Szekely","CNP":"6770116168669","Age":21,"Address":"Aleea Mihai Viteazul nr. 6B, bl. D, et. 4, ap. 6, Ocna Sibiului, Covasna, CP 235137","BedID":27},{"FirstName":"Augustina","LastName":"Mihailescu","CNP":"6270101147389","Age":21,"Address":"B-dul. Albert Einstein nr. 3\/5, bl. C, et. 0, ap. 1, Avrig, Gorj, CP 028182","BedID":28},{"FirstName":"Costin","LastName":"Avram","CNP":"5590924452796","Age":18,"Address":"Calea Vlad \u021aepe\u0219 4\/6, Odobe\u0219ti, Br\u0103ila, CP 105609","BedID":68},{"FirstName":"Manuela","LastName":"Stoica","CNP":"6970511081766","Age":21,"Address":"P-\u021ba Frasinului 93, Negre\u0219ti, Harghita, CP 000940","BedID":21},{"FirstName":"C\u0103t\u0103lin","LastName":"Dinca","CNP":"6101218433051","Age":23,"Address":"B-dul. Mircea cel B\u0103tr\u00e2n 4A, Constan\u021ba, Maramure\u021b, CP 450941","BedID":100},{"FirstName":"Costel","LastName":"Sandor","CNP":"5160907380076","Age":20,"Address":"Splaiul Piersicului 73, Lugoj, Ialomi\u021ba, CP 445353","BedID":0},{"FirstName":"Achim","LastName":"Szabo","CNP":"5160829282676","Age":19,"Address":"Calea Mihai Viteazul 28, Babadag, Bihor, CP 306921","BedID":9},{"FirstName":"Catrina","LastName":"Dascalu","CNP":"6670202297322","Age":18,"Address":"P-\u021ba Cri\u0219an nr. 0A, bl. D, ap. 75, G\u0103e\u0219ti, Teleorman, CP 753852","BedID":89}];
}) ;


</script>
</body>

</html>
