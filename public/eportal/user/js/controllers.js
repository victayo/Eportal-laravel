(function () {
    angular.module('Eportal.User.Controllers', [])
        .controller('UserController', ['$scope', 'userService', function ($scope, userService) {
            $scope.details = userService.getDetails();
        }])
        .controller('RegisterController', ['$scope', 'userService', 'propertyService', function ($scope, userService, propertyService) {
            $scope.submit = function(){
                console.log(propertyService.getProperty());
                console.log(userService.getDetails());
            }
        }])
})();