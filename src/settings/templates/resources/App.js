'use strict';

// Declare app level module which depends on filters, and services

angular.module('ModuleDesignerApp', [
	//'ngRoute',
	'ngMaterial',
	'ModuleDesignerApp.controllers'
]).

config(function($mdThemingProvider) {
  $mdThemingProvider.theme('default')
    .primaryPalette('blue')
    .accentPalette('pink');
}).

config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});