(function () {
    angular.module('Eportal.User.Services', [])
        .factory('userService', ['$http', 'userURL', function ($http, userURL) {
            var details = {};
            return {
                getDetails: function () {
                    return details;
                },
                setDetails: function($details){
                    details = $details;
                },
                register: function (data) {
                    return $http.post(userURL.register, data)
                        .then(function (response) {
                            return response.data;
                        });
                }
            }
        }])
        .value('userURL', {
            register: '/api/user/register'
        })
        .value('userWeb', {
            register: ''
        })
})();