(function () {
    angular.module('Eportal.Property.Controllers', [])
        .controller('PropertyController', ['$scope', 'propertyService', function ($scope, propertyService) {
            $scope.property = propertyService.getProperty();
            $scope.sessions = [];
            $scope.terms = [];
            $scope.schools = [];
            $scope.departments = [];
            $scope.classes = [];
            $scope.subject = [];

            $scope.hasDepartment = $('#department').length > 0;
            $scope.hasSubject = $('#subject').length > 0;

            propertyService.getSessions()
                .then(function (data) {
                    if (data.success) {
                        $scope.sessions = data.sessions;
                    }
                });

            propertyService.getSchools()
                .then(function (data) {
                    if (data.success) {
                        $scope.schools = data.schools;
                    }
                });

            $scope.$watch('property.session', function (session) {
                if (!session) {
                    $scope.property.term = null;
                    $scope.terms = [];
                    return;
                }
                propertyService.getTerms(session)
                    .then(function (data) {
                        if (data.success) {
                            $scope.terms = data.terms;
                        }
                    });
            });

            $scope.$watch('property.school', function (school) {
                if (!school) {
                    $scope.property.class = null;
                    $scope.property.department = null;
                    $scope.property.subject = null;
                    $scope.classes = [];
                    $scope.departments = [];
                    $scope.subjects = [];
                    return;
                }
                propertyService.getClasses(school)
                    .then(function (data) {
                        if (data.success) {
                            $scope.classes = data.classes;
                            $scope.property.class = null;
                            $scope.property.department = null;
                            $scope.departments = [];
                            $scope.property.subject = null;
                            $scope.subjects = [];
                        }
                    });
            });

            $scope.$watch('property.class', function ($class) {
                if (!$class) {
                    $scope.property.subject = null;
                    $scope.property.department = null;
                    $scope.departments = [];
                    $scope.subjects = [];
                    return;
                }
                propertyService.getDepartments($scope.property.school, $class)
                    .then(function (data) {
                        if (data.success) {
                            $scope.departments = data.departments;
                            $scope.property.subject = null;
                            $scope.subjects = [];
                        }
                    });
            });

            $scope.$watch('property.department', function (department) {
                if (!department || !$scope.hasDepartment) {
                    $scope.property.subject = null;
                    $scope.subjects = [];
                    return;
                }
                if(!$scope.hasSubject){
                    return;
                }
                propertyService.getSubjects($scope.property.school, $scope.property.class, department)
                    .then(function (data) {
                        if (data.success) {
                            $scope.subjects = data.subjects;
                        }
                    });
            });
        }]);
})();