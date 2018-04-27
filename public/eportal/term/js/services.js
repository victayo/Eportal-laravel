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