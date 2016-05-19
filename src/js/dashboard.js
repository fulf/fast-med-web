angular.module('FastMed', ['ngMaterial'])
.controller('dashboardController', function($scope, $http){
	$scope.patients = [{"FirstName":"Denis","LastName":"Boboc","CNP":"5880208067263","Age":23,"Diagnostic":"Gripa","Address":"Splaiul Piersicului 8, Mun. Sulina, Timi\u0219, CP 482211","BedID":52},{"FirstName":"Adina","LastName":"Cosma","CNP":"6821213522554","Age":21,"Address":"Splaiul Clo\u0219ca nr. 1B, bl. A, ap. 98, R\u00e2\u0219nov, D\u00e2mbovi\u021ba, CP 041595","BedID":95},{"FirstName":"Geta","LastName":"Szekely","CNP":"6770116168669","Age":21,"Address":"Aleea Mihai Viteazul nr. 6B, bl. D, et. 4, ap. 6, Ocna Sibiului, Covasna, CP 235137","BedID":27},{"FirstName":"Augustina","LastName":"Mihailescu","CNP":"6270101147389","Age":21,"Address":"B-dul. Albert Einstein nr. 3\/5, bl. C, et. 0, ap. 1, Avrig, Gorj, CP 028182","BedID":28},{"FirstName":"Costin","LastName":"Avram","CNP":"5590924452796","Age":18,"Address":"Calea Vlad \u021aepe\u0219 4\/6, Odobe\u0219ti, Br\u0103ila, CP 105609","BedID":68},{"FirstName":"Manuela","LastName":"Stoica","CNP":"6970511081766","Age":21,"Address":"P-\u021ba Frasinului 93, Negre\u0219ti, Harghita, CP 000940","BedID":21},{"FirstName":"C\u0103t\u0103lin","LastName":"Dinca","CNP":"6101218433051","Age":23,"Address":"B-dul. Mircea cel B\u0103tr\u00e2n 4A, Constan\u021ba, Maramure\u021b, CP 450941","BedID":100},{"FirstName":"Costel","LastName":"Sandor","CNP":"5160907380076","Age":20,"Address":"Splaiul Piersicului 73, Lugoj, Ialomi\u021ba, CP 445353","BedID":0},{"FirstName":"Achim","LastName":"Szabo","CNP":"5160829282676","Age":19,"Address":"Calea Mihai Viteazul 28, Babadag, Bihor, CP 306921","BedID":9},{"FirstName":"Catrina","LastName":"Dascalu","CNP":"6670202297322","Age":18,"Address":"P-\u021ba Cri\u0219an nr. 0A, bl. D, ap. 75, G\u0103e\u0219ti, Teleorman, CP 753852","BedID":89}];

	$scope.logout = function(){
		$http({
			method: "DELETE",
			url: 'api/authenticate.php'
		}).then(
			function(){
				location.reload();
			}
		)
	}
});
