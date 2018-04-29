(function () {
    angular.module('Eportal.User.Controllers', [])
        .controller('UserController', ['$scope', 'userService', function ($scope, userService) {
            $scope.details = userService.getDetails();
        }])
        .controller('RegisterController', ['$scope', '$window', 'userService', 'propertyService', function ($scope, $window, userService, propertyService) {
            $scope.btn_disabled = false;
            $scope.submit = function () {
                $scope.btn_disabled = true;
                var property = propertyService.getProperty();
                var details = userService.getDetails();
                details.password = details.username;
                var data = Object.assign({}, details, property);
                var dob = data.dob;
                var day = str_pad(dob.getDate());
                var mth = str_pad(dob.getMonth() + 1);
                var yr = dob.getFullYear();
                data.dob = yr + '-' + mth + '-' + day;
                userService.register(data)
                    .then(function (response) {
                        $scope.btn_disabled = false;
                        if(response.success){
                            $window.location.reload();
                            alert('Student Successfully Registered!');
                            return;
                        }
                        alert('Registration Failed! Check inputs and try again')
                    }, function(){
                        $scope.btn_disabled = false;
                        alert('An error occured. Try again');
                    });
            }

            /**
             *
             * @param n
             * @returns {string}
             * adds leading zero to day and month number less than 10.
             */
            function str_pad(n) {
                return String("0" + n).slice(-2);
            }
        }])
})();