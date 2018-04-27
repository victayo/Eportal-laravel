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