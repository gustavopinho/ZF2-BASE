(function(){
    'use strict';
    angular
        .module('AdminApp')
        .service('ResourceService', ResourceService);

    ResourceService.$inject = ['$resource'];

    function ResourceService($resource)
    {
        return $resource('/api/acl/resource.json', {}, {
            getList: {
                method: 'GET',
                url: '/api/acl/resource/page/:page.json',
                headers: {
                    'Content-Type': 'application/json'
                }
            },
            getAll: {
                method: 'GET',
                url: '/api/acl/resource/get-all.json',
                headers: {
                    'Content-Type': 'application/json'
                }
            },
            get: {
                method :'GET',
                url: '/api/acl/resource/:id.json',
                headers: {'Content-Type': 'application/json'}
            },
            update: {
                method :'PUT',
                url: '/api/acl/resource/:id.json',
                headers: {'Content-Type': 'application/json'}
            },
            delete: {
                method :'DELETE',
                url: '/api/acl/resource/:id.json',
                headers: {'Content-Type': 'application/json'}
            },
        });
    }
})();
