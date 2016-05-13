<div ng-controller="BlocksFieldsCtrl">
	<md-tab label="{vtranslate('LBL_BLOCKS_AND_FIELDS', $QUALIFIED_MODULE)}">
		<md-content class="md-padding" layout="column" style="position: relative;">
			<md-button class="md-fab md-primary" ng-click="addBlock()" style="position: absolute; right: 23px; top: 0px;">
				<md-tooltip md-direction="bottom">
					{vtranslate('LBL_ADD_BLOCK', $QUALIFIED_MODULE)}
				</md-tooltip>
				<i class="fa fa-plus" style="font-size: 23px; line-height: 60px"></i>
			</md-button>
					
			<div ng-repeat="(index, block) in module.a_blocks" layout="column" class="md-whiteframe-3dp md-padding" style="margin-bottom: 15px; margin-top: 15px;">
				<h2 class="md-title">
					<i class="fa fa-reorder"></i>
					<span ng-if="block.a_languages.fr_fr != ''">[[block.a_languages.fr_fr]]</span>
					<span ng-if="block.a_languages.fr_fr == ''">{vtranslate('LBL_BLOCK', $QUALIFIED_MODULE)} [[index+1]]</span>
				</h2>
				
				<div layout="row" layout-wrap>
					<md-input-container flex="25">
						<label>{vtranslate('LBL_BLOCK_LABEL', $QUALIFIED_MODULE)}</label>
						<input ng-model="block.label">
					</md-input-container>
					
					<md-input-container flex="25" ng-repeat="language in a_languages | orderBy: 'label'">					
						<label>{vtranslate('LBL_BLOCK_TRANSLATION', $QUALIFIED_MODULE)} ([[language.code]])</label>
						<input ng-model="block.a_languages[language.code]">
					</md-input-container>
				</div>
				
				<div layout="row" style="position: relative;">
					<!-- <h2 class="md-subhead" flex="50">
						<i class="fa fa-terminal"></i>
						{vtranslate('LBL_FIELDS', $QUALIFIED_MODULE)}
					</h2>
					
					<div flex></div> -->
						
					<md-button class="md-fab md-mini" ng-click="showAddFieldPopup($event, block)" style="position: absolute; right: 0; top: -27px;">
						<md-tooltip md-direction="bottom">
				          {vtranslate('LBL_ADD_FIELD', $QUALIFIED_MODULE)}
				        </md-tooltip>
						<i class="fa fa-plus" style="font-size: 16px;"></i>
					</md-button>
				</div>
				
				<md-content class="fields-container md-padding" layout="row" layout-wrap>
					<div ng-repeat="field in block.a_fields" flex="50" layout-padding>
						<div layout="row" class="field-summary md-padding md-whiteframe-1dp">
							[[field.fieldname]]
							<div flex></div>
							<div>
								<i class="fa fa-exclamation-triangle" ng-class="field.mandatory ? '' : 'disabled'"></i>
								<i class="fa fa-key" ng-class="field.identifier ? '' : 'disabled'"></i>
								<i class="fa fa-plus" ng-class="field.quickCreate ? '' : 'disabled'"></i>
								<i class="fa fa-pencil" ng-class="field.massEdit ? '' : 'disabled'"></i>
								<i class="fa fa-bars" ng-class="field.listView ? '' : 'disabled'"></i>
								<i class="fa fa-external-link" ng-class="field.popup ? '' : 'disabled'"></i>
								<i class="fa fa-link" ng-class="field.relatedList ? '' : 'disabled'"></i>
								<i class="fa fa-lock" ng-class="field.readOnly ? '' : 'disabled'"></i>
							</div>
						</div>
					</div>
				</md-content>
				
			</div>
		</md-content>
	</md-tab>
</div>