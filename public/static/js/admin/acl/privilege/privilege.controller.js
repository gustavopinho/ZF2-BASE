(function(){
    'use strict';

    angular
        .module('AdminApp')
        .controller('PrivilegeController', PrivilegeController);

    function PrivilegeController()
    {
        var vm = this;
        vm.name = 'PrivilegeController'
    }
})();
