<div ng-controller="GeneralCtrl">
	<md-tab label="{vtranslate('LBL_PROPERTIES', $QUALIFIED_MODULE)}">
		<md-content class="md-padding" layout="column">
			<h2 class="md-title">
				<i class="fa fa-cog"></i>
				{vtranslate('LBL_GENERAL', $QUALIFIED_MODULE)}
			</h2>
		  
		  	<div layout="row">
				<md-input-container flex="20">
					<label>{vtranslate('LBL_MODULE_TYPE', $QUALIFIED_MODULE)}</label>
					<md-select ng-model="module.type">
						<md-option ng-repeat="type in a_moduleTypes" ng-value="[[type]]">[[type.label]]</md-option>
					</md-select>
					<md-tooltip md-direction="right">
						{vtranslate('LBL_MODULE_TYPE_INFO', $QUALIFIED_MODULE)}
			        </md-tooltip>
				</md-input-container>
					
				<div flex></div>
		
				<md-input-container flex="50">
					<label>{vtranslate('LBL_MODULE_NAME', $QUALIFIED_MODULE)}</label>
					<input ng-model="module.name">
				</md-input-container>
					
				<div flex></div>
				
				<md-input-container flex="20">
					<label>{vtranslate('LBL_MODULE_VERSION', $QUALIFIED_MODULE)}</label>
					<input ng-model="module.version">
				</md-input-container>
				
				<div flex></div>
				
				<md-input-container flex="20">
					<label>{vtranslate('LBL_MODULE_PARENT_TAB', $QUALIFIED_MODULE)}</label>
					<md-select ng-model="module.parentTab">
						<md-option ng-repeat="parentTab in a_parentTab" ng-value="[[parentTab]]">[[parentTab.label]]</md-option>
					</md-select>
				</md-input-container>
			</div>
			
			<h2 class="md-title">
				<i class="fa fa-language"></i>
				{vtranslate('LBL_TRANSLATION', $QUALIFIED_MODULE)}
			</h2>
			
			<div ng-repeat="language in a_languages | orderBy: 'label'">
				<h3 class="md-subhead">
					[[language.label]] ([[language.code]])
				</h3>
			
				<div layout="row">
					<md-input-container flex="45">
						<label>{vtranslate('LBL_SINGULAR_LABEL', $QUALIFIED_MODULE)}</label>
						<input ng-model="module.a_translations[language.code].singular">
					</md-input-container>
					
					<div flex></div>
					
					<md-input-container flex="45">
						<label>{vtranslate('LBL_PLURAL_LABEL', $QUALIFIED_MODULE)}</label>
						<input ng-model="module.a_translations[language.code].plural">
					</md-input-container>
				</div>
			</div>
		</md-content>
	</md-tab>
</div>