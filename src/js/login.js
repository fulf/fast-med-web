angular.module('FastMed', ['ngMaterial', 'ngMessages'])
    .config(function($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette("green");
    })
    .controller("loginController", function($http, $scope){
        $scope.state = null;

        document.onkeyup = function(key){
            if(key.keyCode == 13)
                $scope.login();
        }

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
                    location.reload();
                },
                function(){
                    $scope.state = 'error';
                }
            );
        }

        $scope.runFixture = function(){
            window.open("api/fixtures.php","_blank") ;
        }
    });
