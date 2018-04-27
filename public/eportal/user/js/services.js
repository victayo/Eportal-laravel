(function () {
    angular.module('Eportal.User.Services', [])
        .factory('userService', ['$http', 'userURL', function ($http, userURL) {
            var details = {};
            return {
                getDetails: function () {
                    return details;
                },
                register: function (details, property) {
                    $http.post(userURL.register, {})
                        .then(function (response) {
                            return response.data;
                        });
                }
            }
        }])
        .value('userURL', {
            register: '/api/user/register'
        })
})();