(function() {
    'use strict';

    angular
        .module('AdminApp')
        .service('RoleService', RoleService);

    RoleService.$inject = ['$resource'];

    function RoleService($resource) {
        return $resource('/api/acl/role.json', {}, {
            getList: {
                method: 'GET',
                url: '/api/acl/role/page/:page.json',
                headers: {
                    'Content-Type': 'application/json'
                }
            },
            getAll: {
                method: 'GET',
                url: '/api/acl/role/get-all.json',
                headers: {
                    'Content-Type': 'application/json'
                }
            },
            get: {
                method: 'GET',
                url: '/api/acl/role/:id.json',
                headers: {
                    'Content-Type': 'application/json'
                }
            },
            update: {
                method: 'PUT',
                url: '/api/acl/role/:id.json',
                headers: {
                    'Content-Type': 'application/json'
                }
            },
            delete: {
                method: 'DELETE',
                url: '/api/acl/role/:id.json',
                headers: {
                    'Content-Type': 'application/json'
                }
            },
        });
    }
})();
