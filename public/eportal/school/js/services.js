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