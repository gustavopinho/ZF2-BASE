(function() {
    'use strict';

    angular
        .module('AdminApp')
        .controller('RoleController', RoleController);

    RoleController.$inject = ['$window', 'RoleService']

    function RoleController($window, RoleService) {
        var vm = this;

        // Variables
        vm.sortType = 'id';
        vm.sortReverse = false;
        vm.searchFish = '';
        vm.roles = [];
        vm.allRoles = [];
        vm.role = {
            'id': '',
            'name': '',
            'parent': '',
            'developer': false
        };
        vm.messages = [];
        vm.pages = [];
        vm.page = 1;

        // Functions
        vm.listRoles = listRoles;
        vm.saveRole = saveRole;
        vm.getRole = getRole;
        vm.getParent = getParent;
        vm.deleteRole = deleteRole;

        function listRoles(page) {
            RoleService.getList({page:page},
                function(data) {
                    vm.roles = data.data.entities;
                    vm.pages = data.data.pages;
                },
                function(data) {
                    console.log(data);
                });

            RoleService.getAll({},
                function(data) {
                    vm.allRoles = data.data.entities;
                },
                function(data) {
                    console.log(data);
                });
        }

        function saveRole() {
            vm.role.parent = vm.role.parent == 'null' ? '' : vm.role.parent;
            vm.role.developer = vm.role.developer == false ? 0 : 1;

            if (vm.role.id) {
                RoleService.update({
                        id: vm.role.id
                    }, vm.role,
                    function(data) {
                        vm.role = {
                            'id': '',
                            'name': '',
                            'parent': '',
                            'developer': ''
                        };
                        vm.messages = data.messages;
                        listRoles(vm.page);
                    },
                    function() {
                        console.log(data);
                    });
            } else {
                RoleService.save(vm.role,
                    function(data) {
                        vm.role = {
                            'id': '',
                            'name': '',
                            'parent': '',
                            'developer': ''
                        };
                        vm.messages = data.messages;
                        listRoles(vm.page);
                    },
                    function(data) {
                        console.log(data);
                    });
            }
        }

        function getRole(id) {
            RoleService.get({
                    id: id
                },
                function(data) {
                    vm.role.id = data.data.entity.id;
                    vm.role.name = data.data.entity.name;
                    vm.role.parent = String(data.data.entity.parent);
                    vm.role.developer = data.data.entity.developer;
                    vm.messages = data.messages;
                },
                function(data) {
                    console.log(data);
                });
        }

        function deleteRole(id)
        {
            if($window.confirm('Are you sure to delete this item?'))
            {
                RoleService.delete({id:id},
                    function(data) {
                        vm.messages = data.messages;
                        listRoles(vm.page);
                    },
                    function(){
                        console.log(data);
                    });
            }
        }

        function getParent(id) {
            var parent = $.grep(vm.roles, function(e) {
                return e.id == id;
            });
            return (parent == '') ? '' : parent[0]['name'];
        }
        listRoles(vm.page);
    }
})();
