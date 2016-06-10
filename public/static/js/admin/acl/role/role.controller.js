(function(){
    'use strict';

    angular
        .module('AdminApp')
        .controller('RoleController', RoleController);

    function RoleController()
    {
        var vm = this;
        vm.name = 'RoleController'
    }
})();
