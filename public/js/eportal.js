(function(){
    angular.module('Eportal.Session.Services', [])
        .factory('sessionService', ['$http','sessionURL', function($http, sessionURL){
            return {
                getSessions: function(){
                    return $http.get(sessionURL.list)
                        .then(function(response){
                            return response.data;
                        })
                },

                show: function(session){
                    return $http.get(sessionURL.show+session)
                        .then(function (response) {
                            return response.data;
                        });
                },

                create: function(data){
                    return $http.post(sessionURL.create, data)
                        .then(function (response) {
                            return response.data;
                        })
                },

                update: function(id, data){
                    return $http.post(sessionURL.update+id, data)
                        .then(function(response){
                            return response.data
                        });
                },

                destroy: function(id){
                    return $http.delete(sessionURL, {session: id})
                        .then(function (response) {
                            return response.data;
                        });
                },

                getTerms: function(session){
                    return $http.get(sessionURL.getTerms, {
                        params: { session: session }
                    }).then(function(response){
                        return response.data;
                    });
                },

                addTerms: function(session, terms){
                    return $http.post(sessionURL.addTerms, {
                        session: session,
                        terms: terms
                    }).then(function(response){
                        return response.data;
                    });
                },
                removeTerms: function(session, terms){
                    return $http.post(sessionURL.removeTerms, {
                        session: session,
                        terms: terms
                    }).then(function (response) {
                        return response.data;
                    });
                }
            };
        }])
        .value('sessionURL', {
            list: '/api/session',
            create: '/api/session',
            show: '/api/session/',
            update: '/api/session/',
            destroy: '/api/session/delete',
            getTerms: '/api/session/term',
            addTerms: '/api/session/term/add',
            removeTerms: '/api/session/term/remove'
        });
})();
(function(){
    angular.module('Eportal.Session.Controllers', [])
        .controller('SessionController', ['$scope', 'sessionService', function ($scope, sessionService) {

        }])
})();
(function () {
    angular.module('Eportal.Session', [
        'Eportal.Session.Services',
        'Eportal.Session.Controllers',
    ]);
})();
(function(){
    angular.module('Eportal.Term.Services', [])
        .factory('termService', ['$http','termURL', function($http, termURL){
            return {
                getTerms: function(){
                    return $http.get(termURL.list)
                        .then(function(response){
                            var data = response.data;
                            if(data.success){
                                return data.terms;
                            }
                            //handle failure
                        })
                },
                show: function(term){
                    return $http.get(termURL.show+term);
                },

                create: function(data){
                    return $http.post(termURL.create, data)
                },

                update: function(id, data){
                    return $http.post(termURL.update+id, data);
                },

                destroy: function(id){
                    return $http.delete(termURL, {term: id});
                }
            };
        }])
        .value('termURL', {
            list: '/api/term',
            create: '/api/term',
            show: '/api/term/',
            update: '/api/term/',
            destroy: '/api/term/delete'
        });
})();
(function(){
    angular.module('Eportal.Term.Controllers', [])
        .controller('TermController', ['$scope', 'termService', function ($scope, termService) {

        }])
})();
(function () {
    angular.module('Eportal.Term', [
        'Eportal.Term.Services',
        'Eportal.Term.Controllers',
    ]);
})();
(function () {
    angular.module('Eportal.School.Services', [])
        .factory('schoolService', ['$http', 'schoolURL', function ($http, schoolURL) {
            return {
                getSchools: function () {
                    return $http.get(schoolURL.list)
                        .then(function (response) {
                            return response.data;
                        })
                },
                show: function (school) {
                    return $http.get(schoolURL.show + school)
                        .then(function (response) {
                            return response.data;
                        });
                },

                create: function (data) {
                    return $http.post(schoolURL.create, data)
                        .then(function (response) {
                            return response.data;
                        })
                },

                update: function (id, data) {
                    return $http.post(schoolURL.update + id, data)
                        .then(function (response) {
                            return response.data;
                        });
                },

                destroy: function (id) {
                    return $http.delete(schoolURL, {school: id})
                        .then(function (response) {
                            return response.data;
                        });
                },

                getClasses: function (school) {
                    return $http.get(schoolURL.getClasses, {
                        params: {school: school}
                    }).then(function (response) {
                        return response.data;
                    });
                },

                addClasses: function (school, classes) {
                    return $http.post(schoolURL.addClasses, {
                        school: school,
                        classes: classes
                    }).then(function (response) {
                        return response.data;
                    });
                },

                removeClasses: function (school, classes) {
                    return $http.post(schoolURL.removeClasses, {
                        school: school,
                        classes: classes
                    }).then(function (response) {
                        return response.data;
                    });
                }
            };
        }])
        .value('schoolURL', {
            list: '/api/school',
            create: '/api/school',
            show: '/api/school/',
            update: '/api/school/',
            destroy: '/api/school/delete',
            getClasses: '/api/school/class',
            addClasses: '/api/school/class/add',
            removeClasses: '/api/school/class/remove'
        });
})();
(function(){
    angular.module('Eportal.School.Controllers', [])
        .controller('SchoolController', ['$scope', 'schoolService', function ($scope, schoolService) {

        }])
})();
(function () {
    angular.module('Eportal.School', [
        'Eportal.School.Services',
        'Eportal.School.Controllers',
    ]);
})();
(function () {
    angular.module('Eportal.Class.Services', [])
        .factory('classService', ['$http', 'classURL', function ($http, classURL) {
            return {
                getClasses: function () {
                    return $http.get(classURL.list)
                        .then(function (response) {
                            return response.data;
                        })
                },
                show: function ($class) {
                    return $http.get(classURL.show + $class)
                        .then(function (response) {
                            return response.data;
                        });
                },

                create: function (data) {
                    return $http.post(classURL.create, data)
                        .then(function (response) {
                            return response.data;
                        });
                },

                update: function (id, data) {
                    return $http.post(classURL.update + id, data)
                        .then(function (response) {
                            return response.data;
                        });
                },

                destroy: function (id) {
                    return $http.delete(classURL, {class: id})
                        .then(function (response) {
                            return response.data;
                        });
                },

                getDepartments: function (school, $class) {
                    return $http.get(classURL.getDepartments, {
                        params: {
                            school: school,
                            class: $class
                        }
                    }).then(function (response) {
                        return response.data;
                    });
                },

                addDepartments: function (school, $class, departments) {
                    return $http.post(classURL.addDepartments, {
                        school: school,
                        class: $class,
                        departments: departments
                    }).then(function (response) {
                        return response.data;
                    });
                },

                removeDepartments: function (school, $class, departments) {
                    return $http.post(classURL.removeDepartments, {
                        school: school,
                        class: $class,
                        departments: departments
                    }).then(function (response) {
                        return response.data;
                    });
                }
            };
        }])
        .value('classURL', {
            list: '/api/class',
            create: '/api/class',
            show: '/api/class/',
            update: '/api/class/',
            destroy: '/api/class/delete',
            getDepartments: '/api/class/department',
            addDepartments: '/api/class/department/add',
            removeDepartments: '/api/class/department/remove'
        });
})();
(function(){
    angular.module('Eportal.Class.Controllers', [])
        .controller('ClassController', ['$scope', 'classService', function ($scope, classService) {

        }])
})();
(function () {
    angular.module('Eportal.Class', [
        'Eportal.Class.Services',
        'Eportal.Class.Controllers',
    ]);
})();
(function () {
    angular.module('Eportal.Department.Services', [])
        .factory('departmentService', ['$http', 'departmentURL', function ($http, departmentURL) {
            return {
                getDepartments: function () {
                    return $http.get(departmentURL.list)
                        .then(function (response) {
                            return response.data;
                        });
                },
                show: function (department) {
                    return $http.get(departmentURL.show + department)
                        .then(function (response) {
                            return response.data;
                        });
                },

                create: function (data) {
                    return $http.post(departmentURL.create, data)
                        .then(function (response) {
                            return response.data;
                        });
                },

                update: function (id, data) {
                    return $http.post(departmentURL.update + id, data)
                        .then(function (response) {
                            return response.data;
                        });
                },

                destroy: function (id) {
                    return $http.delete(departmentURL, {department: id})
                        .then(function (response) {
                            return response.data;
                        });
                },

                getSubjects: function (school, $class, department) {
                    return $http.get(departmentURL.getSubjects, {
                        params: {
                            school: school,
                            class: $class,
                            department: department
                        }
                    }).then(function (response) {
                        return response.data;
                    });
                },

                addSubjects: function (school, $class, department, subjects) {
                    return $http.post(departmentURL.addSubjects, {
                        school: school,
                        class: $class,
                        department: department,
                        subjects: subjects
                    });
                },
                removeSubjects: function (school, $class, department, subjects) {
                    return $http.post(departmentURL.removeSubjects, {
                        school: school,
                        class: $class,
                        department: department,
                        subjects: subjects
                    }).then(function (response) {
                        return response.data;
                    });
                }
            };
        }])
        .value('departmentURL', {
            list: '/api/department',
            create: '/api/department',
            show: '/api/department/',
            update: '/api/department/',
            destroy: '/api/department/delete',
            getSubjects: '/api/department/subject',
            addSubjects: '/api/department/subject/add',
            removeSubjects: '/api/department/subject/remove'
        });
})();
(function(){
    angular.module('Eportal.Department.Controllers', [])
        .controller('DepartmentController', ['$scope', 'departmentService', function ($scope, departmentService) {

        }])
})();
(function () {
    angular.module('Eportal.Department', [
        'Eportal.Department.Services',
        'Eportal.Department.Controllers',
    ]);
})();
(function () {
    angular.module('Eportal.Subject.Services', [])
        .factory('subjectService', ['$http', 'subjectURL', function ($http, subjectURL) {
            return {
                getSubjects: function () {
                    return $http.get(subjectURL.list)
                        .then(function (response) {
                            return response.data;
                        })
                },
                show: function (subject) {
                    return $http.get(subjectURL.show + subject)
                        .then(function (response) {
                            return response.data;
                        });
                },

                create: function (data) {
                    return $http.post(subjectURL.create, data)
                        .then(function (response) {
                            return response.data;
                        });
                },

                update: function (id, data) {
                    return $http.post(subjectURL.update + id, data)
                        .then(function (response) {
                            return response.data;
                        });
                },

                destroy: function (id) {
                    return $http.delete(subjectURL, {subject: id})
                        .then(function (response) {
                            return response.data;
                        });
                }
            };
        }])
        .value('subjectURL', {
            list: '/api/subject',
            create: '/api/subject',
            show: '/api/subject/',
            update: '/api/subject/',
            destroy: '/api/subject/delete'
        });
})();
(function(){
    angular.module('Eportal.Subject.Controllers', [])
        .controller('SubjectController', ['$scope', 'subjectService', function ($scope, subjectService) {

        }])
})();
(function () {
    angular.module('Eportal.Subject', [
        'Eportal.Subject.Services',
        'Eportal.Subject.Controllers',
    ]);
})();
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
(function () {
    angular.module('Eportal.Property', [
        'Eportal.Property.Services',
        'Eportal.Property.Controllers'
    ]);
})();
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
(function () {
    angular.module('Eportal.User', [
        'Eportal.User.Services',
        'Eportal.User.Controllers'
    ])
})();
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