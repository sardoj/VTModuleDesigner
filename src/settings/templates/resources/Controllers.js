'use strict';

/* Controllers */

angular.module('ModuleDesignerApp.controllers', []).

controller('AppCtrl', function ($scope)
{  
	$scope.a_languages = [{code: 'fr_fr', label: 'Français'}, {code: 'en_us', label: 'English'}];	
	$scope.module = {a_blocks: []};
	
}).

controller('GeneralCtrl', function ($scope)
{  
  	$scope.a_moduleTypes = [{label: app.vtranslate('LBL_MODULE')}, {label: app.vtranslate('LBL_EXTENSION')}];
  	
}).

controller('BlocksFieldsCtrl', function ($scope, $mdDialog, $mdMedia)
{	
	//Add block
  	$scope.addBlock = function(block)
  	{
  		if(block == undefined)
  		{
  			block = {
						label: 'LBL_BLOCK_'+($scope.module.a_blocks.length + 1),
						a_languages: {en_us: '', fr_fr: ''},
						a_fields: []
					};
  		}
  		
  		$scope.module.a_blocks.push(block);
  	}
  	
  	//Show add field popup
  	$scope.showAddFieldPopup = function(ev, block)
  	{
  		$scope.selectedBlock = block;
  		
		var useFullScreen = ($mdMedia('sm') || $mdMedia('xs'))  && $scope.customFullscreen;
		
		$mdDialog.show({
		  controller: FieldPopupController,
		  templateUrl: 'layouts/vlayout/modules/Settings/ModuleDesigner/FieldPopup/Container.html',
		  parent: angular.element(document.body),
		  targetEvent: ev,
		  clickOutsideToClose: false,
		  fullscreen: useFullScreen
		})
		.then(function(field) {
			var block_index = $scope.module.a_blocks.indexOf($scope.selectedBlock);
			
			if(block_index > -1)
			{
				$scope.module.a_blocks[block_index].a_fields.push(field);
			}
			
		});
		$scope.$watch(function() {
		  return $mdMedia('xs') || $mdMedia('sm');
		    }, function(wantsFullScreen) {
		      $scope.customFullscreen = (wantsFullScreen === true);
		    });
	}
  	
  	//Init
  	$scope.init = function()
  	{
	  	//Create first block
		var block1 = {
			label: 'LBL_BLOCK_GENERAL_INFORMATION',
			a_languages: {en_us: 'General information', fr_fr: 'Informations générales'},
			a_fields: []
		};	
		$scope.addBlock(block1);
		
		//Create second block
		var block2 = {
			label: 'LBL_BLOCK_SYSTEM_INFORMATION',
			a_languages: {en_us: 'System information', fr_fr: 'Informations système'},
			a_fields: []
		};
		
		$scope.addBlock(block2);
	}

	$scope.init();
});

function FieldPopupController($scope, $mdDialog)
{
	$scope.a_fieldTypes = [
							{label: 'Text', uitype: 1},
							{label: 'Decimal', uitype: 7},
							{label: 'Integer', uitype: 7},
							{label: 'Percent', uitype: 72},
							{label: 'Currency', uitype: 71},
							{label: 'Date', templateUrl: 'layouts/vlayout/modules/Settings/ModuleDesigner/FieldPopup/Date.html'},
							{label: 'Email', templateUrl: 'layouts/vlayout/modules/Settings/ModuleDesigner/FieldPopup/Email.html'},
							{label: 'Phone', templateUrl: 'layouts/vlayout/modules/Settings/ModuleDesigner/FieldPopup/Phone.html'},
							{label: 'Picklist', templateUrl: 'layouts/vlayout/modules/Settings/ModuleDesigner/FieldPopup/Picklist.html'},
							{label: 'Multi-Select', templateUrl: 'layouts/vlayout/modules/Settings/ModuleDesigner/FieldPopup/Multi-Select.html'},
						];
	
  $scope.hide = function() {
    $mdDialog.hide();
  };
  $scope.cancel = function() {
    $mdDialog.cancel();
  };
  $scope.createField = function() {
    $mdDialog.hide($scope.field);
  };
}