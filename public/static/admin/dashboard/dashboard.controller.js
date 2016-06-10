(function(){
    'use strict';

    angular
        .module('AdminApp')
        .controller('DashBoardController', DashBoardController);

    function DashBoardController()
    {
        var vm = this;
        vm.name = 'Meu Controller'
    }
})();
