<div class="row-fluid widget_header" style="margin-top: 10px;">
	<div class="span12">
		<a href="index.php?module={$MODULE}&view=Index&parent=Settings"><h3>{vtranslate('LBL_MODULEDESIGNER', $QUALIFIED_MODULE)}</h3></a>
		<hr/>
	</div>
</div>

<div id="md-container">
	<div id="md-header">
		<div id="md-tab-general" class="md-tab"><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/config.png" alt="{vtranslate('LBL_GENERAL_ALT', $QUALIFIED_MODULE)}" /> {vtranslate('LBL_GENERAL', $QUALIFIED_MODULE)}</div>
		<div id="md-tab-blocks-fields" class="md-tab"><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/field.png" alt="{vtranslate('LBL_BLOCKS_FIELDS_ALT', $QUALIFIED_MODULE)}" /> {vtranslate('LBL_BLOCKS_FIELDS', $QUALIFIED_MODULE)}</div>
		<div id="md-tab-custom-links" class="md-tab"><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/link.png" alt="{vtranslate('LBL_CUSTOM_LINKS_ALT', $QUALIFIED_MODULE)}" /> {vtranslate('LBL_CUSTOM_LINKS', $QUALIFIED_MODULE)}</div>
		<div id="md-tab-related-lists" class="md-tab"><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/related.png" alt="{vtranslate('LBL_RELATED_LISTS_ALT', $QUALIFIED_MODULE)}" /> {vtranslate('LBL_RELATED_LISTS', $QUALIFIED_MODULE)}</div>
		<div id="md-tab-events" class="md-tab"><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/event.png" alt="{vtranslate('LBL_EVENTS_ALT', $QUALIFIED_MODULE)}" /> {vtranslate('LBL_EVENTS', $QUALIFIED_MODULE)}</div>
		<div id="md-tab-filters" class="md-tab"><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/filter.png" alt="{vtranslate('LBL_FILTERS_ALT', $QUALIFIED_MODULE)}" /> {vtranslate('LBL_FILTERS', $QUALIFIED_MODULE)}</div>
		<div id="md-tab-custom" class="md-tab"><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/custom.png" alt="{vtranslate('LBL_CUSTOM_ALT', $QUALIFIED_MODULE)}" /> {vtranslate('LBL_CUSTOM', $QUALIFIED_MODULE)}</div>
		<div id="md-tab-export" class="md-tab"><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/export.png" alt="{vtranslate('LBL_EXPORT_ALT', $QUALIFIED_MODULE)}" /> {vtranslate('LBL_EXPORT', $QUALIFIED_MODULE)}</div>
	</div><!-- md-header -->	
	
	<div id="md-body">
			<div id="md-trash" class="md-trash"></div>
	
			<div id="md-page-general" class="md-page">
				{include file='modules/Settings/'|@cat:$MODULE|@cat:'/General.tpl'}
			</div><!-- md-page-general -->
			
			<div id="md-page-blocks-fields" class="md-page">
				{include file='modules/Settings/'|@cat:$MODULE|@cat:'/BlocksFields.tpl'}
			</div><!-- md-page-blocks-fields -->
			
			<div id="md-page-custom-links" class="md-page">
				{include file='modules/Settings/'|@cat:$MODULE|@cat:'/CustomLinks.tpl'}
			</div><!-- md-page-custom-links -->
			
			<div id="md-page-related-lists" class="md-page">
				{include file='modules/Settings/'|@cat:$MODULE|@cat:'/RelatedLists.tpl'}
			</div><!-- md-page-related-list -->
			
			<div id="md-page-events" class="md-page">
				{include file='modules/Settings/'|@cat:$MODULE|@cat:'/Events.tpl'}
			</div><!-- md-page-events -->
			
			<div id="md-page-filters" class="md-page">
				{include file='modules/Settings/'|@cat:$MODULE|@cat:'/Filters.tpl'}
			</div><!-- md-page-filters -->
			
			<div id="md-page-custom" class="md-page">
				{include file='modules/Settings/'|@cat:$MODULE|@cat:'/Custom.tpl'}
			</div><!-- md-page-custom -->
			
			<div id="md-page-export" class="md-page">
				{include file='modules/Settings/'|@cat:$MODULE|@cat:'/Export.tpl'}
			</div><!-- md-page-export -->	
			
			
	</div><!-- md-body -->
	
</div><!-- md-container -->

<input type="hidden" id="md-default-language" value="{$DEFAULT_LANGUAGE}" />
<a id="md-edit-popup-link" data-fancybox-type="iframe" href="#">Edit popup link</a>