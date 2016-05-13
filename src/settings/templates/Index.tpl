<script type="text/javascript">
	var currentLayout = '{$LAYOUT}';
	var currentModule = '{$MODULE}';
	var a_translations = JSON.parse('{$TRANSLATIONS}');
</script>

<div ng-app="ModuleDesignerApp" style="margin-bottom: 20px;">
	<div ng-controller="AppCtrl" ng-cloak>
		<h1 class="md-title">[[translate('LBL_MODULEDESIGNER')]]</h1>
		<div ng-include="getActiveView()">
			
		</div>
	</div>
</div>