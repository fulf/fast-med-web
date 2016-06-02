function t(s) {
    console.log(s);
    var DICTIONARY = {
        'ro': {
            'Patient added successfully!': 'Pacientul a fost adăugat cu succes!',
            'Failed to add patient!': 'Nu s-a reușit adăugarea pacientului!',
            'Release patient?': 'Externați pacientul?',
            'This operation cannot be undone.': 'Această operație este ireversibilă.',
            'Confirm': 'Confirmă',
            'Cancel': 'Anulează',
            'The patient has been released!': 'Pacientul a fost externat!',
            'Drug sent to delivery!': 'Medicament trimis spre livrare!',
            'Patient updated succesfully!': 'Pacientul a fost updatat cu succes!',
            'Failed to edit patient!': 'Modificarea pacientului a eșuat!',
            'Started': 'Recepționat',
            'Obstacle': 'Obstacol',
            'Not found': 'Negăsit',
            'Lost line': 'Pierdut linia',
            'Completed': 'Livrat'
        }
    };
    if (DICTIONARY[lang] && DICTIONARY[lang][s])
        return DICTIONARY[lang][s];
    return s;
}

angular.module('FastMed', ['ngMaterial'])
    .config(function ($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette("green");
    })
    .controller('tableController', function ($rootScope, $scope, $mdDialog) {
        $rootScope.page = 1;
        $rootScope.limit = 20;
        $rootScope.table = {
            Page: 1,
            Limit: 20
        };

        $scope.t = t;

        $scope.viewPatient = function (patient) {
            $mdDialog.show({
                controller: 'viewPatientController',
                templateUrl: 'assets/templates/viewPatient.tmpl.php',
                locals: {
                    patient: patient
                },
                clickOutsideToClose: true
            });
        }
    })
    .controller('navbarController', function ($scope, $rootScope, $http) {
        $scope.loadPatients = function (page, limit) {
            page = page || $rootScope.table.Page;
            limit = limit || $rootScope.table.Limit;
            if (limit < 0)
                limit = $rootScope.table.Limit;
            if (page < 0)
                page = 1;
            if (page > ($rootScope.table.Pages || 1))
                page = $rootScope.table.Pages;

            $http({
                method: "GET",
                url: 'api/patients.php',
                params: {
                    page: page,
                    limit: limit,
                    filters: JSON.stringify({
                        "Released": "NULL"
                    })
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
        $scope.loadPatients(1, 20);
        setInterval(function() {
            $scope.loadPatients($scope.page, $scope.limit);
        }, 2000);
    })
    .controller('toolbarController', function ($scope, $rootScope, $http, $mdDialog, $timeout) {
        $scope.logout = function () {
            $http({
                method: "DELETE",
                url: 'api/authenticate.php'
            }).then(
                function () {
                    location.reload();
                }
            )
        };

        $scope.addPatient = function () {
            $mdDialog.show({
                controller: 'addPatientController',
                templateUrl: 'assets/templates/addPatient.tmpl.php',
                clickOutsideToClose: true
            });
        };

        $rootScope.showMessage = function (error, message, time) {
            time = time || 1000;
            $rootScope.message = {
                text: message,
                type: error ? "md-warn" : "md-primary"
            };
            $timeout($rootScope.removeMessage, time);
        };

        $rootScope.removeMessage = function () {
            $rootScope.message = null;
        };
    })
    .controller('viewPatientController', function ($rootScope, $scope, $mdDialog, $http, patient) {
        $scope.patient = JSON.parse(JSON.stringify(patient));
        $scope.state = 'viewing';
        $scope.edit = function () {
            $scope.state = 'editing';
        };
        $scope.loadBeds = function() {
            return $http({
                method: "GET",
                url: 'api/beds.php'
            }).then(
                function (response) {
                    if (response.data.success) {
                        $scope.beds = response.data.data.records;
                        $scope.patient.Bed = $scope.beds.find( function(val) { return val.ID == $scope.patient.BedID } );
                    }
                }
            );
        };
        $scope.loadBeds();

        $scope.save = function () {
            if($scope.state=='medicate')
                $http({
                    method: "POST",
                    url: 'api/commands.php',
                    data: {
                        Type: "Delivery",
                        DrugID: $scope.sentDrug,
                        BedID: $scope.patient.BedID,
                        RobotID: 1
                    }
                }).then(
                    function (response) {
                        if (response.data.success) {
                            $scope.drugs = response.data.data.records;
                            $rootScope.showMessage(false, t("Drug sent to delivery!"));
                        }
                    }
                );
            else
                $http({
                    method: "PUT",
                    url: 'api/patients.php?filters={"ID":'+$scope.patient.ID+'}',
                    data: {
                        "CNP": $scope.patient.CNP,
                        "FirstName": $scope.patient.FirstName,
                        "LastName": $scope.patient.LastName,
                        "Age": $scope.patient.Age,
                        "Address": $scope.patient.Address,
                        "Diagnosis": $scope.patient.Diagnosis,
                        "BedID": $scope.patient.BedID
                    }
                }).then(
                    function (response) {
                            $scope.patient = response.data.data;
                            $rootScope.showMessage(false, t("Patient updated succesfully!"));
                    }, function() {
                        $rootScope.showMessage(true, t("Failed to edit patient!"));
                        $scope.patient=patient;
                    }
                );
            $scope.state = 'viewing';
        };
        $scope.cancel = function () {
            $scope.state = 'viewing';
        };
        $scope.close = function () {
            $mdDialog.hide();
        };
        $scope.release = function () {
            swal({
                title: t("Release patient?"),
                text: t("This operation cannot be undone."),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: t("Confirm"),
                cancelButtonText: t("Cancel"),
                closeOnConfirm: false
            }, function () {
                $http({
                    method: "DELETE",
                    url: 'api/patients.php?filters={"ID":'+$scope.patient.ID+'}'
                }).then(function(){
                    swal(t("The patient has been released!"), "", "success");
                    $mdDialog.hide();
                });
            });
        };
        $scope.medicate = function () {
            $scope.state = "medicate";
        };
        $scope.loadDrugs = function() {
            return $http({
                method: "GET",
                url: 'api/drugs.php'
            }).then(
                function (response) {
                    if (response.data.success) {
                        $scope.drugs = response.data.data.records;
                    }
                }
            );
        };
        $scope.history = function () {
            $scope.state = "history";
            $scope.ajax = true;
            $http({
                method: "GET",
                url: 'api/requests.php?filters={"BedID":'+$scope.patient.BedID+'}&orderDir=DESC'
            }).then(
                function (response) {
                    if (response.data.success) {
                        $scope.logs = response.data.data.records;
                        $scope.ajax = false;
                        $scope.logs = $scope.logs.map( function(val) { val.Status = t(val.Status); return val } );
                    }
                }
            );

        };
        $scope.back = function () {
            $scope.state = "viewing";
        }
    })
    .controller('addPatientController', function ($rootScope, $scope, $mdDialog, $http) {
        $scope.patient = {};
        $scope.close = function () {
            $mdDialog.hide();
        };
        $scope.add = function () {
            $http({
                method: "POST",
                url: 'api/patients.php',
                data: $scope.patient
            }).then(
                function () {
                    console.log('here');
                    $rootScope.showMessage(false, t("Patient added successfully!"));
                }, function() {
                    console.log('or here');
                    $rootScope.showMessage(true, t("Failed to add patient!"));
                }
            );
            $mdDialog.hide();
        };
        $scope.loadBeds = function() {
            return $http({
                method: "GET",
                url: 'api/beds.php'
            }).then(
                function (response) {
                    if (response.data.success) {
                        $scope.beds = response.data.data.records;
                    }
                }
            );
        };
    });
