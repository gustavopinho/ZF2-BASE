(function() {
    'use strict';

    angular
        .module('AdminApp')
        .controller('PrivilegeController', PrivilegeController);

    PrivilegeController.$inject = [
        '$window',
        'PrivilegeService',
        'ResourceService',
        'RoleService'
    ];

    function PrivilegeController($window, PrivilegeService, ResourceService, RoleService) {
        var vm = this;

        // Variables
        vm.sortType = 'id';
        vm.sortReverse = false;
        vm.searchFish = '';
        vm.privileges = [];
        vm.resources = [];
        vm.roles = [];

        vm.privilege = {
            'id': '',
            'name': '',
            'resource': '',
            'role': ''
        };
        vm.messages = [];
        vm.pages = [];
        vm.page = 1;

        // Functions
        vm.listPrivileges = listPrivileges;
        vm.getRole = getRole;
        vm.getResource = getResource;

        function listPrivileges(page) {
            vm.page = page;
            PrivilegeService.getList({page:page},
                function(data) {
                    vm.privileges = data.data.entities;
                    vm.pages = data.data.pages;
                },
                function(data) {
                    console.log(data);
                });
            listRoles();
            listResources();
        }

        function listRoles() {
            RoleService.getAll({},
                function(data) {
                    vm.roles = data.data.entities;
                },
                function(data) {
                    console.log(data);
                });
        }

        function listResources() {
            ResourceService.getAll({},
                function(data) {
                    vm.resources = data.data.entities;
                },
                function(data) {
                    console.log(data);
                });
        }

        function getResource(id) {
            var resource = $.grep(vm.resources, function(e) {
                return e.id == id;
            });
            return (resource == '') ? '' : resource[0]['name'];
        }

        function getRole(id) {
            var role = $.grep(vm.roles, function(e) {
                return e.id == id;
            });
            return (role == '') ? '' : role[0]['name'];
        }

        listPrivileges(vm.page);
    }
})();
