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