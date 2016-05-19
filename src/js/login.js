angular.module('FastMed', ['ngMaterial'])
.controller('LoginCtrl', function($scope){
  $scope.open_page = function(){
    window.open("php/fixtures.php","_blank") ;
  }
}) ;
