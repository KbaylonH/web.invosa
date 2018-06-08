var app = angular.module('FoxlabelApp', ['ui.router', 'ui.bootstrap', 'oc.lazyLoad','ngAnimate', 'ngSanitize']);
app.config(['$ocLazyLoadProvider', '$stateProvider', '$urlRouterProvider' , function($ocLazyLoadProvider, $stateProvider, $urlRouterProvider) {
  $urlRouterProvider.otherwise("/dashboard");
    //Config For ocLazyLoading
    $ocLazyLoadProvider.config({
        'debug': true, // For debugging 'true/false'
        'events': true, // For Event 'true/false'
        'modules': [{ // Set modules initially
            name : 'state1', // State1 module
            files: [
            'js/angular-morris/angular-morris.min.js',
            'js/angular-tablesorter/angular-tablesort.js',
            'js/angularjs/controller/DashboardController.js'
            ]
        },{ // Set modules initially
            name : 'state2', // State2 module
            files: [
            'js/angularjs/controller/BlankController.js'
            ]
          },{ // Set modules initially
            name : 'state3', // State3 module
            files: [
            'js/angularjs/controller/UIBootstrapController.js'
            ]
          },{ // Set modules initially
            name : 'state4', // State4 module
            files: [
            'js/angular-file-upload/angular-file-upload.min.js',
            'js/angularjs/controller/FileUploadController.js'
            ]
          }]
        });
        //Config/states of UI Router
        $stateProvider
        .state('state1', {
          url: "/dashboard",
          templateUrl:"dashboard.html",
          controller: "DashboardController",
          resolve: {
            loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load('state1'); // Resolve promise and load before view
              }]
            }
          }).state('state2', {
            url: "/blank-page",
            templateUrl: "blank.html",            
            controller: "BlankController",
            resolve: {
              loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load('state2'); // Resolve promise and load before view
              }]
            }
          }).state('state3', {
            url: "/buttons",
            templateUrl: "buttons.html",            
            controller: "UIBootstrapController",
            resolve: {
              loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load('state3'); // Resolve promise and load before view
              }]
            }
          }).state('state4', {
            url: "/typography",
            templateUrl: "typography.html",            
            controller: "DashboardController",
            resolve: {
              loadMyCtrl: ['$ocLazyLoad', function($ocLazyLoad) {
                return $ocLazyLoad.load('state4'); // Resolve promise and load before view
              }]
            }
          });
        }]);