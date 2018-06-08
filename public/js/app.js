var app = angular.module('InvosaApp', ['ui.router', 'ui.bootstrap', 'oc.lazyLoad','ngAnimate', 'ngSanitize']);

// config
app.config(['$ocLazyLoadProvider', '$stateProvider', '$urlRouterProvider', function($ocLazyLoadProvider, $stateProvider, $urlRouterProvider){

  $urlRouterProvider.otherwise("/dashboard");

  $ocLazyLoadProvider.config({
    'debug': true,
    'events': true,
    'modules': [
      {
        name: 'state1',
        files: [
          'js/angularjs/controller/DashboardController.js'
        ]
      },
      {
        name: 'state2',
        files: [
          'js/angularjs/controller/RutasController.js'
        ]
      },
    ]
  });

  $stateProvider
    .state('state1', {
      url: "/dashboard",
      templateUrl:"/views/dashboard.html",
      controller: "DashboardController",
      resolve: {
        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load('state1');
        }]
      }
    })
    .state('state2', {
      url: "/rutas",
      templateUrl:"/views/rutas.html",
      controller: "RutasController",
      resolve: {
        loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load('state2');
        }]
      }
    })

}]).run(['$rootScope', '$state', '$http', '$timeout', function ($rootScope, $state, $http, $timeout) {
    $rootScope.$state = $state;
    $http.defaults.headers.common['X-CSRF-TOKEN'] = document.getElementsByTagName("meta")[0].content;
    $http.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
}]);