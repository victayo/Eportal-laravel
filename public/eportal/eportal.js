(function(){
    var eportal = angular.module('Eportal', [
        'Eportal.Session',
        'Eportal.Term',
        'Eportal.School',
        'Eportal.Class',
        'Eportal.Department',
        'Eportal.Subject',
        'Eportal.Property',
        'Eportal.User'
    ]);
    eportal.factory('httpRequestInterceptor', [function () {
        return {
            request: function(config){
                config.headers['Accept'] = 'application/json';
                if(config.method === 'POST') {
                    config.headers['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
                }
                return config;
            }
        }
    }]);
    eportal.config(function ($httpProvider) {
        $httpProvider.interceptors.push('httpRequestInterceptor');
    })
})();