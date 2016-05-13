{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}

{strip}
<script type="text/javascript">
	var currentLayout = '{$LAYOUT}';
	var currentModule = '{$MODULE}';
</script>

<div ng-app="ModuleDesignerApp" style="margin-bottom: 20px;">
	<div ng-controller="AppCtrl" ng-cloak>
		<h1 class="md-title">{vtranslate('LBL_MODULEDESIGNER', $QUALIFIED_MODULE)}</h1>
		<md-content class="md-whiteframe-1dp" flex>
		    <md-tabs md-dynamic-height md-border-bottom>	    	
		    	{include file='modules/Settings/'|@cat:$MODULE|@cat:'/General.tpl'}
		    	{include file='modules/Settings/'|@cat:$MODULE|@cat:'/BlocksAndFields.tpl'}
		    </md-tabs>
		</md-content>
	</div>
</div>
{/strip}