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