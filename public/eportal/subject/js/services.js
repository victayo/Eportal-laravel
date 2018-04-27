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