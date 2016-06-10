(function(){
    'use strict';

    angular
        .module('AdminApp')
        .service('ResourceService', ['$resource', ResourceService])
        .controller('ResourceController',['$window', 'ResourceService', ResourceController]);

    function ResourceService($resource)
    {
        return $resource('/api/acl/resource.json', {}, {
            getList: {
                method :'GET',
                headers: {'Content-Type': 'application/json'}
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

    function ResourceController($window, ResourceService)
    {
        var vm = this;

        // Variables
        vm.sortType = 'id';
        vm.sortReverse = false;
        vm.searchFish = '';
        vm.resources = [];
        vm.resource = {'id' : '', 'name' : ''};

        // Functions
        vm.saveResource = saveResource;
        vm.getResource = getResource;
        vm.deleteResource = deleteResource;

        function listResources() {
            ResourceService.getList({},
                function(data) {
                    vm.resources = data.data.entities;
                },
                function(data) {
                    console.log(data);
                });
        }

        function saveResource()
        {
            if(vm.resource.id) {
                ResourceService.update({id:vm.resource.id}, vm.resource,
                    function(data) {
                        vm.resource = {'id' : '', 'name' : ''};
                        listResources();
                    },
                    function(){
                        console.log(data);
                    });
            } else {
                ResourceService.save(vm.resource,
                    function(data){
                        vm.resource = {'id' : '', 'name' : ''};
                        listResources();
                    },
                    function(data){
                        console.log(data);
                    });
            }
        }

        function getResource(id)
        {
            ResourceService.get({id:id},
                function(data) {
                    vm.resource.id = data.data.entity.id;
                    vm.resource.name = data.data.entity.name;
                },
                function(data) {
                    console.log(data);
                });
        }

        function deleteResource(id)
        {
            if($window.confirm('Are you sure to delete this item?'))
            {
                ResourceService.delete({id:id},
                    function(data) {
                        listResources();
                    },
                    function(){
                        console.log(data);
                    });
            }
        }
        listResources();
    }
})();
