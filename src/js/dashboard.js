function t(s){
    var DICTIONARY = {
        'ro': {
            'Patient added successfully!': 'Pacientul a fost adăugat cu succes!',
            'Failed to add patient!': 'Nu s-a reușit adăugarea pacientului!',
            'Release patient?': 'Externați pacientul?',
            'This operation cannot be undone.': 'Această operație este ireversibilă.',
            'Confirm': 'Confirmă',
            'Cancel': 'Anulează'
        }
    };
    if(DICTIONARY[lang] && DICTIONARY[lang][s])
        return DICTIONARY[lang][s];
    return s;
}

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
            templateUrl: 'assets/templates/viewPatient.tmpl.php',
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
    };
    $scope.loadPatients(1,20);
})
.controller('toolbarController', function($scope, $rootScope, $http, $mdDialog, $timeout) {
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
            templateUrl: 'assets/templates/addPatient.tmpl.php',
            clickOutsideToClose: true
        }).then(function(answer) {
            console.log("Success");
            $rootScope.showMessage(false, t("Patient added successfully!"));
        }, function() {
            $rootScope.showMessage(true, t("Failed to add patient!"));
            console.log("Error");
        });
    }
    
    $rootScope.showMessage = function(error, message, time){
        time = time || 1000;
        $rootScope.message = {
            text: message,
            type: error ? "md-warn" : "md-primary"
        };
        $timeout($rootScope.removeMessage, time);
    };

    $rootScope.removeMessage = function(){
        $rootScope.message = null;
    }
})
.controller('viewPatientController', function($scope, $mdDialog, patient){
    $scope.patient = patient;
    $scope.state = 'viewing';
    $scope.edit = function(){
        //TODO: Implement editing
        $scope.state = 'editing';
    };
    $scope.save = function(){
        //TODO: Implement saving
        $scope.state = 'viewing';
    };
    $scope.cancel = function(){
        //TODO: Cleanup canceling
        $scope.state = 'viewing';
    };
    $scope.close = function(){
        $mdDialog.hide();
    };
    $scope.release = function(){
        //TODO: Implement releasing
        swal({
            title: t("Release patient?"),
            text: t("This operation cannot be undone."),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: t("Confirm"),
            cancelButtonText: t("Cancel"),
            closeOnConfirm: false
        }, function(){
            swal("Pacientul a fost externat!", "", "success");
            $mdDialog.hide();
        });
    };
    $scope.medicate = function(){
        //TODO: Implement medication
      $scope.state = "medicate";
    };
    $scope.history = function(){
        //TODO: Implement history
        $scope.state = "history";
    };
    $scope.back = function(){
        $scope.state = "viewing";
    }
})
.controller('addPatientController', function($scope, $mdDialog){
    //TODO: Implement adding a patient
    $scope.patient = {};
    $scope.close = function(){
        $mdDialog.hide();
    };
    $scope.add = function(){
        $mdDialog.hide();
    }
});
