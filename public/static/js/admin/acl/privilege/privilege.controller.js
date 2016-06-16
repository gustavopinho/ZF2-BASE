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
        vm.loading = false;
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
        vm.savePrivilege = savePrivilege;
        vm.getPrivilege = getPrivilege;
        vm.deletePrivilege = deletePrivilege;

        function listPrivileges(page) {
            vm.loading = true;
            vm.page = page;
            PrivilegeService.getList({page:page},
                function(data) {
                    vm.privileges = data.data.entities;
                    vm.pages = data.data.pages;
                    vm.loading = false;
                },
                function(data) {
                    console.log(data);
                });
            listRoles();
            listResources();
        }

        function savePrivilege() {
            if (vm.privilege.id) {
                PrivilegeService.update({
                        id: vm.privilege.id
                    }, vm.privilege,
                    function(data) {
                        vm.privilege = {
                            'id': '',
                            'name': '',
                            'role': '',
                            'resource': ''
                        };
                        vm.messages = data.messages;
                        listPrivileges(vm.page);
                    },
                    function() {
                        console.log(data);
                    });
            } else {
                PrivilegeService.save(vm.privilege,
                    function(data) {
                        vm.privilege = {
                            'id': '',
                            'name': '',
                            'role': '',
                            'resource': ''
                        };
                        vm.messages = data.messages;
                        listPrivileges(vm.page);
                    },
                    function(data) {
                        console.log(data);
                    });
            }
        }

        function getPrivilege(id) {
            PrivilegeService.get({
                    id: id
                },
                function(data) {
                    vm.privilege.id = data.data.entity.id;
                    vm.privilege.name = data.data.entity.name;
                    vm.privilege.role = String(data.data.entity.role);
                    vm.privilege.resource = String(data.data.entity.resource);
                },
                function(data) {
                    console.log(data);
                });
        }

        function deletePrivilege(id)
        {
            if($window.confirm('Are you sure to delete this item?'))
            {
                PrivilegeService.delete({id:id},
                    function(data) {
                        vm.messages = data.messages;
                        listPrivileges(vm.page);
                    },
                    function(){
                        console.log(data);
                    });
            }
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
