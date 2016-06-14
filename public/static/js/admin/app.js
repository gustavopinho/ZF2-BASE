(function() {
    'use strict'

    var baseUrl = 'http://' + window.location.host;

    angular
        .module('AdminApp', [
            'ngRoute',
            'ngResource',
            'ngSanitize'
        ])
        .config(['$routeProvider', '$locationProvider', adminRoute]);

    function adminRoute($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(true);

        $routeProvider.
        when('/', {
            templateUrl: baseUrl + '/static/js/admin/dashboard/dashboard.template.html',
            controller: 'DashBoardController',
            controllerAs: 'vm'
        }).
        when('/acl/roles', {
            templateUrl: baseUrl + '/static/js/admin/acl/role/role.template.html',
            controller: 'RoleController',
            controllerAs: 'vm'
        }).
        when('/acl/resources', {
            templateUrl: baseUrl + '/static/js/admin/acl/resource/resource.template.html',
            controller: 'ResourceController',
            controllerAs: 'vm'
        }).
        when('/acl/privileges', {
            templateUrl: baseUrl + '/static/js/admin/acl/privilege/privilege.template.html',
            controller: 'PrivilegeController',
            controllerAs: 'vm'
        }).
        otherwise({
            templateUrl: baseUrl + '/static/js/admin/error/404.template.html',
            controller: 'ErrorController',
            controllerAs: 'vm'
        });
    }
})();
