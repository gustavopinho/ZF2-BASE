(function() {
    'use strict';

    angular
        .module('AdminApp')
        .service('PrivilegeService', PrivilegeService);

    PrivilegeService.$inject = ['$resource'];

    function PrivilegeService($resource) {
        return $resource('/api/acl/privilege.json', {}, {
            getList: {
                method: 'GET',
                url: '/api/acl/privilege/page/:page.json',
                headers: {
                    'Content-Type': 'application/json'
                }
            },
            get: {
                method: 'GET',
                url: '/api/acl/privilege/:id.json',
                headers: {
                    'Content-Type': 'application/json'
                }
            },
            update: {
                method: 'PUT',
                url: '/api/acl/privilege/:id.json',
                headers: {
                    'Content-Type': 'application/json'
                }
            },
            delete: {
                method: 'DELETE',
                url: '/api/acl/privilege/:id.json',
                headers: {
                    'Content-Type': 'application/json'
                }
            },
        });
    }
})();
