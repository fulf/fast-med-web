angular.module('FastMed', ['ngMaterial'])
.config(function($mdThemingProvider) {
	$mdThemingProvider.theme('default')
		.primaryPalette("green");
})
.controller('tableController', function($rootScope, $scope, $mdDialog) {
    $rootScope.page = 1;
    $rootScope.limit = 20;
    $rootScope.table = {
        Page: 1,
        Limit: 20
    };

    $scope.viewPatient = function (patient) {
        $mdDialog.show({
            controller: 'viewPatientController',
            templateUrl: 'assets/templates/viewPatient.tmpl.html',
            locals: {
                patient: patient
            },
            clickOutsideToClose: true
        })
        .then(function(answer) {
            $scope.status = 'You said the information was "' + answer + '".';
        }, function() {
            $scope.status = 'You cancelled the dialog.';
        });
    }
})
.controller('navbarController', function($scope, $rootScope, $http) {
    $scope.loadPatients = function(page, limit) {
        page = page || $rootScope.table.Page;
        limit = limit || $rootScope.table.Limit;
        if(limit < 0)
            limit = $rootScope.table.Limit;
        if(page < 0)
            page = 1;
        if(page > ($rootScope.table.Pages || 1))
            page = $rootScope.table.Pages;

        $http({
            method: "GET",
            url: 'api/patients.php',
            params: {
                page: page,
                limit: limit
            }
        }).then(
            function (response) {
                if (response.data.success) {
                    $rootScope.patients = response.data.data.records;
                    $rootScope.table.Page = page;
                    $rootScope.table.Limit = limit;
                    $rootScope.table.Pages = Math.ceil(response.data.data.total / $rootScope.table.Limit);

                    $scope.page = page;
                    $scope.limit = limit;
                }
            }
        );
    }
    $scope.loadPatients(1,20);
})
.controller('toolbarController', function($scope, $http, $mdDialog) {
    $scope.logout = function(){
        $http({
            method: "DELETE",
            url: 'api/authenticate.php'
        }).then(
            function(){
                location.reload();
            }
        )
    };

    $scope.addPatient = function(){
        $mdDialog.show({
            controller: 'addPatientController',
            templateUrl: 'assets/templates/addPatient.tmpl.html',
            clickOutsideToClose: true
        }).then(function(answer) {
            $scope.status = 'You said the information was "' + answer + '".';
        }, function() {
            $scope.status = 'You cancelled the dialog.';
        });;
    }
})
.controller('viewPatientController', function($scope, patient){
    $scope.patient = patient;
})
.controller('addPatientController', function($scope){
    console.log("Hello world!");
});
