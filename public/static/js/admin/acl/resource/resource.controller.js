(function() {
    'use strict';

    angular
        .module('AdminApp')
        .controller('ResourceController', ResourceController);

    ResourceController.$inject = ['$window', 'ResourceService'];

    function ResourceController($window, ResourceService) {
        var vm = this;

        // Variables
        vm.sortType = 'id';
        vm.sortReverse = false;
        vm.searchFish = '';
        vm.loading = false;
        vm.resources = [];
        vm.resource = {
            'id': '',
            'name': ''
        };
        vm.messages = [];
        vm.pages = [];
        vm.page = 1;

        // Functions
        vm.listResources = listResources;
        vm.saveResource = saveResource;
        vm.getResource = getResource;
        vm.deleteResource = deleteResource;

        function listResources(page) {
            vm.page = page;
            vm.loading = true;
            ResourceService.getList({page:page},
                function(data) {
                    vm.resources = data.data.entities;
                    vm.pages =  data.data.pages;
                    vm.loading = false;
                },
                function(data) {
                    console.log(data);
                });
        }

        function saveResource() {
            if (vm.resource.id) {
                ResourceService.update({
                        id: vm.resource.id
                    }, vm.resource,
                    function(data) {
                        vm.resource = {
                            'id': '',
                            'name': ''
                        };
                        vm.messages = data.messages;
                        listResources(vm.page);
                    },
                    function() {
                        console.log(data);
                    });
            } else {
                ResourceService.save(vm.resource,
                    function(data) {
                        vm.resource = {
                            'id': '',
                            'name': ''
                        };
                        vm.messages = data.messages;
                        listResources(vm.page);
                    },
                    function(data) {
                        console.log(data);
                    });
            }
        }

        function getResource(id) {
            ResourceService.get({
                    id: id
                },
                function(data) {
                    vm.resource.id = data.data.entity.id;
                    vm.resource.name = data.data.entity.name;
                    vm.messages = data.messages;
                },
                function(data) {
                    console.log(data);
                });
        }

        function deleteResource(id) {
            if ($window.confirm('Are you sure to delete this item?')) {
                ResourceService.delete({
                        id: id
                    },
                    function(data) {
                        vm.messages = data.messages;
                        listResources(vm.page);
                    },
                    function() {
                        console.log(data);
                    });
            }
        }
        listResources(vm.page);
    }
})();
