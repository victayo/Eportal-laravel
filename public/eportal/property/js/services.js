(function () {
    angular.module('Eportal.Property.Services', [])
        .factory('propertyService', ['$http', 'sessionService', 'schoolService', 'classService', 'departmentService',
            function ($http, sessionService, schoolService, classService, departmentService) {
                var $property = {};
                return {
                    getSessions: function () {
                        return sessionService.getSessions();
                    },
                    getTerms: function (session) {
                        return sessionService.getTerms(session);
                    },
                    getSchools: function () {
                        return schoolService.getSchools();
                    },
                    getClasses: function(school){
                        return schoolService.getClasses(school);
                    },
                    getDepartments: function(school, $class){
                        return classService.getDepartments(school, $class);
                    },
                    getSubjects: function(school, $class, department){
                        return departmentService.getSubjects(school, $class, department);
                    },
                    getProperty: function(){
                        return $property;
                    },
                    setProperty: function (property) {
                        $property = property;
                    }
                };
            }]);
})();