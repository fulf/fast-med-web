angular.module('FastMed', ['ngMaterial', 'ngMessages'])
    .controller("loginController", function($http, $scope){
        $scope.state = null;

        $scope.login = function(){
            $scope.state = 'loading';
            $http({
                method: 'POST',
                url: 'api/authenticate.php',
                headers: {
                    'Content-Type': 'application/json'
                },
                data: { 
                    'username': $scope.user.username,
                    'password': $scope.user.password
                }
            }).then(
                function(){
                    $scope.state = 'success';
                },
                function(){
                    $scope.state = 'error';
                }
            );
        }

        $scope.open_page = function(){
            window.open("php/api/fixtures.php","_blank") ;
        }
    });
