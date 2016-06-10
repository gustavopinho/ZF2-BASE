(function(){
    'use strict'

    var baseUrl = 'http://'+window.location.host;

    angular
        .module('AdminApp', [
            'ngRoute',
            'ngResource',
            'ngSanitize'
        ])
        .config(['$routeProvider', '$locationProvider',adminRoute]);

        function adminRoute($routeProvider, $locationProvider)
        {
            $locationProvider.html5Mode(true);

            $routeProvider.
                when('/', {
                  templateUrl: baseUrl + '/static/admin/dashboard/dashboard.template.html',
                  controller: 'DashBoardController',
                  controllerAs: 'vm'
                }).
                when('/acl/role', {
                  templateUrl: baseUrl + '/static/admin/acl/role/role.template.html',
                  controller: 'RoleController',
                  controllerAs: 'vm'
                }).
                otherwise({
                  redirectTo: '/'
                });
        }
})();
