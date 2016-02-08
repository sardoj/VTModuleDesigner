<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="layouts/vlayout/modules/Settings/{$MODULE}/resources/PopupUtils.js"></script>
<script type="text/javascript" src="libraries/jquery/jquery.min.js"></script>
<script type="text/javascript" src="layouts/vlayout/modules/Settings/{$MODULE}/resources/jqueryCaret.js"></script>
</head>

<body>
<div style="font-family: Arial,Verdana,'Times New Roman',sans-serif;">
<h2>{$a_field.UITypeNum} - {vtranslate($a_field.UITypeName, $QUALIFIED_MODULE)}</h2>

<form action="index.php?module={$MODULE}&view=EditField" method="post">
<table style="font-size:12px;">
<tr>
	<td colspan="3"><h3>{vtranslate("LBL_FIELD_DESCRIPTION", $QUALIFIED_MODULE)}</h3></td>
</tr>
<tr>
	<td>{vtranslate("LBL_FIELD_NAME", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="text" name="field_name" size="25" maxlength="25" value="{$a_field.fieldName}" onkeyup="md_setFieldName(this, 'entity_identifier_fieldname'); md_setLabel(this, 'label', 'LBL_'); md_setColumnName(this, 'column_name', 'LBL_')"/></td>
</tr>
<tr>
	<td>{vtranslate("LBL_FIELD_LABEL", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="text" name="label" size="50" value="{$a_field.label}" /></td>
</tr>
<tr>
	<td>{vtranslate("LBL_FIELD_TABLE_NAME", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="text" name="table_name" size="50" value="{$a_field.tableName}" /></td>
</tr>
<tr>
	<td>{vtranslate("LBL_FIELD_COLUMN_NAME", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="text" name="column_name" size="50" value="{$a_field.columnName}" /></td>
</tr>
<tr>
	<td>{vtranslate("LBL_FIELD_COLUMN_TYPE", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="text" name="column_type" size="50" value="{$a_field.UITypeDBType}" /></td>
</tr>
{foreach item=language from=$a_languages}
{assign var=label value='label_'|cat:$language}
<tr>
	<td>{vtranslate("LBL_FIELD_LABEL_TRANSLATION", $QUALIFIED_MODULE)} <em>{$language}</em></td>
	<td colspan="2"><input type="text" name="label-{$language}" size="50" value="{$a_field.$label}" /></td>
</tr>
{/foreach}

{if $a_field.UITypeNum == 10}
{foreach key=key item=relatedModule from=$a_field.relatedModule}
<tr class="related_module">
	<td>{vtranslate("LBL_RELATED_MODULE", $QUALIFIED_MODULE)}</td>
	<td colspan="2">
		<select name="related_modules[]" onchange="md_showOrHideCustomField(this)">
			<option value="">&nbsp;</option>
			<option value="CUSTOM" {if !in_array($relatedModule, $a_modules)}selected="selected"{/if}>{vtranslate('LBL_CUSTOM_RELATED_MODULE', $QUALIFIED_MODULE)}</option>
			{foreach item=module from=$a_modules}
			<option value="{$module}" {if !empty($a_field.relatedModule) && $relatedModule == $module}selected="selected"{/if}>{$module} ({vtranslate($module, $QUALIFIED_MODULE)})</option>
			{/foreach}
		</select>
		<a href="#" onclick="md_deleteRelatedModule(this); return false;" {if $key == 0}style="display:none;"{/if} class="delete-related-module"><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/delete.png" alt="{vtranslate('LBL_DELETE_RELATED_MODULE', $QUALIFIED_MODULE)}" /></a>
	</td>
</tr>
<tr class="custom_related_module" {if empty($a_field.relatedModule) || in_array($relatedModule, $a_modules)}style="display:none;"{/if}>
	<td>&nbsp;</td>
	<td><input type="text" name="related_modules[]" size="30" {if !in_array($relatedModule, $a_modules)}value="{$relatedModule}"{/if} /></td>
</tr>
<tr class="add_related_list" {if !$CAN_ADD_RELATED_LIST}style="display: none;"{/if}>
	<td>{vtranslate("LBL_CREATE_RELATED_LIST", $QUALIFIED_MODULE)}</td>
	<td><input type="checkbox" name="add_related_list[]" {if !isset($a_field.addRelatedList.$key) || $a_field.addRelatedList.$key == true}checked="checked"{/if} /></td>
</tr>
{/foreach}
<tr>
	<td colspan="3"><a href="javascript:md_addRelatedModule()">{vtranslate("LBL_ADD_RELATED_MODULE", $QUALIFIED_MODULE)}</a></td>
</tr>
{else if $a_field.UITypeNum == 15 || $a_field.UITypeNum == 16 || $a_field.UITypeNum == 33}
<tr>
	<td>{vtranslate("LBL_PICKLIST_OPTIONS", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="text" name="picklist_values" size="50" value="{$a_field.pickListValues}" /><br /><em>{vtranslate("LBL_PICKLIST_OPTIONS_TOOLTIP", $QUALIFIED_MODULE)}</em></td>
</tr>
{/if}
{if $a_field.UITypeNum == 7}
<tr>
	<td>{vtranslate("LBL_FIELD_NUMERIC_TYPE", $QUALIFIED_MODULE)}</td>
	<td>
	<input type="radio" name="numeric_type" value="I" {if $a_field.UITypeDataType == 'I' || empty($a_field.UITypeDataType)}checked="checked"{/if} />{vtranslate("LBL_FIELD_INTEGER", $QUALIFIED_MODULE)}
	<input type="radio" name="numeric_type" value="N" {if $a_field.UITypeDataType == 'N'}checked="checked"{/if} />{vtranslate("LBL_FIELD_DECIMAL", $QUALIFIED_MODULE)}
	<input type="radio" name="numeric_type" value="NN" {if $a_field.UITypeDataType == 'NN'}checked="checked"{/if} />{vtranslate("LBL_FIELD_NEGATIVE_NUMBER", $QUALIFIED_MODULE)}
	</td>
</tr>
{/if}
{if $a_field.UITypeNum == 5 || $a_field.UITypeNum == 6 || $a_field.UITypeNum == 23}
<tr>
	<td>{vtranslate("LBL_FIELD_DEFAULT_DATE", $QUALIFIED_MODULE)}</td>
	<td colspan="2">
	<input type="radio" name="generated_type" value="1" {if $a_field.generatedType == 1}checked="checked"{/if} />{vtranslate("LBL_GENERATED_TYPE_1", $QUALIFIED_MODULE)}
	<input type="radio" name="generated_type" value="2" {if $a_field.generatedType == 2 || empty($a_field.generatedType)}checked="checked"{/if} />{vtranslate("LBL_GENERATED_TYPE_2", $QUALIFIED_MODULE)}
	</td>
</tr>
{else}
<tr>
	<td>{vtranslate("LBL_FIELD_DEFAULT_VALUE", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="text" name="default_value" size="50" value="{$a_field.defaultValue}" /></td>
</tr>
{/if}
<tr>
	<td>{vtranslate("LBL_FIELD_HELP_INFO_LABEL", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="text" name="help_info_label" size="50" value="{$a_field.helpInfoLabel}" onkeyup="md_showOrHideHelpInfoTranslation(this, 'LBL_', 'help-info-translation');"/></td>
</tr>
{foreach item=language from=$a_languages}
{assign var=label value='helpInfoLabel_'|cat:$language}
<tr class="help-info-translation" {if empty($a_field.helpInfoLabel)}style="display: none"{/if}>
	<td>{vtranslate("LBL_FIELD_HELP_INFO_LABEL_TRANSLATION", $QUALIFIED_MODULE)} <em>{$language}</em></td>
	<td colspan="2"><input type="text" name="help-info-label-{$language}" size="50" value="{$a_field.$label}" /></td>
</tr>
{/foreach}
<tr>
	<td>{vtranslate("LBL_FIELD_DISPLAY_TYPE", $QUALIFIED_MODULE)}</td>
	<td colspan="2">
	<input type="radio" name="display_type" value="1" {if $a_field.displayType == 1}checked="checked"{/if} />{vtranslate("LBL_DISPLAY_TYPE_1", $QUALIFIED_MODULE)}
	<input type="radio" name="display_type" value="2" {if $a_field.displayType == 2}checked="checked"{/if} />{vtranslate("LBL_DISPLAY_TYPE_2", $QUALIFIED_MODULE)}
	<input type="radio" name="display_type" value="3" {if $a_field.displayType == 3}checked="checked"{/if} />{vtranslate("LBL_DISPLAY_TYPE_3", $QUALIFIED_MODULE)}
	</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td colspan="2"><input type="button" onclick="md_popupSave();" value="{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}" /></td>
</tr>
<tr>
	<td colspan="3"><h3>{vtranslate("LBL_OPTIONS", $QUALIFIED_MODULE)}</h3></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/mandatory.png" alt="{vtranslate('LBL_MANDATORY_ALT', $QUALIFIED_MODULE)}" /> {vtranslate('LBL_MANDATORY', $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="checkbox" name="mandatory" value="1" {if $a_field.mandatory}checked="checked"{/if} /></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/entityidentifier.png" alt="{vtranslate("LBL_ENTITY_IDENTIFIER_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_ENTITY_IDENTIFIER", $QUALIFIED_MODULE)}</td>
	<td><input type="checkbox" name="is_entity_identifier" value="1" {if $a_field.isEntityIdentifier}checked="checked"{/if} onclick="md_showOrHidenEntityIdentifierFieldName(this, 'entity_identifier_fieldname')" />
	<td><input type="text" name="entity_identifier_fieldname" value="{if !empty($a_field.entityIdentifierFieldName)}{$a_field.entityIdentifierFieldName}{else}{$a_field.fieldName}{/if}" onkeyup="md_setEntityIdentifierFieldName(this)" {if empty($a_field.isEntityIdentifier)}style="display: none;"{/if} /> <span id="entity_identifier_fieldname"  {if empty($a_field.isEntityIdentifier)}style="display: none;"{/if}>{vtranslate('LBL_ENTITY_IDENTIFIER_FIELD_NAME_HELPINFO', $QUALIFIED_MODULE)}</span></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/filterall.png" alt="{vtranslate("LBL_FILTER_ALL_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_IN_FILTER_ALL", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="checkbox" name="in_filter_all" value="1" {if $a_field.inFilterAll}checked="checked"{/if} /></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/popup.png" alt="{vtranslate("LBL_IN_POPUP_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_IN_POPUP", $QUALIFIED_MODULE)}</td>
	<td><input type="checkbox" name="in_popup" value="1" {if $a_field.inPopup}checked="checked"{/if} /></td>
	<td>Position : <input type ="text" name="popupSequence" size="4"value="{if isset($a_field.popupSequence)}{$a_field.popupSequence}{/if}" /></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/related.png" alt="{vtranslate("LBL_RELATED_LIST_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_IN_RELATED_LIST", $QUALIFIED_MODULE)}</td>
	<td><input type="checkbox" name="in_related_list" {if $a_field.inRelatedList}checked="checked"{/if} value="1" /></td>
	<td>Position : <input type ="text" name="relatedListSequence" size="4" value="{if isset($a_field.relatedListSequence)}{$a_field.relatedListSequence}{/if}" /></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/create.png" alt="{vtranslate("LBL_QUICK_CREATE_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_QUICK_CREATE", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="checkbox" name="quick_create" value="1" {if $a_field.quickCreate}checked="checked"{/if} /></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/massedit.png" alt="{vtranslate("LBL_MASS_EDIT_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_MASS_EDITABLE", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="checkbox" name="mass_editable" value="1" {if $a_field.massEditable}checked="checked"{/if} /></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/readonly.png" alt="{vtranslate("LBL_READ_ONLY_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_READ_ONLY", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="checkbox" name="read_only" value="1" {if $a_field.readOnly}checked="checked"{/if} /></td>
</tr>
</table>
</form>
</div>

<script type="text/javascript">
function md_addRelatedModule()
{ldelim}
	var row = $(".related_module:first").html();
	var row1 = $(".custom_related_module:first").html();
	var row2 = $(".add_related_list:first").html();

	$(".add_related_list:last").after('<tr class="related_module">'+row+'</tr><tr class="custom_related_module" style="display:none">'+row1+'</tr><tr class="add_related_list" {if !$CAN_ADD_RELATED_LIST}style="display: none;"{/if}>'+row2+'</tr>');

	$(".delete-related-module:gt(0)").show();
{rdelim}

function md_deleteRelatedModule(a)
{ldelim}
	$(a).parent().parent().next().next().remove();
	$(a).parent().parent().next().remove();
	$(a).parent().parent().remove();
{rdelim}

function md_showOrHideCustomField(cb)
{ldelim}
	if($(cb).val() == 'CUSTOM')
		$(cb).parent().parent().next().show();
	else
	{ldelim}
		$(cb).parent().parent().next().find("input[type='text']").val('');
		$(cb).parent().parent().next().hide();
	{rdelim}
{rdelim}

function deleteCustomValues(array)
{ldelim}
    var output=[];

    for(var i=0; i<array.length; i++)
    {ldelim}
        if(array[i] != 'CUSTOM' && array[i] != '' && array[i] != undefined)
            output.push(array[i]);
    {rdelim}

    return output;
{rdelim}

function md_popupSave()
{ldelim}

	var o_data = new Object();
	o_data.id							= {if !empty($a_field.id)}'{$a_field.id}'{else}undefined{/if};
	o_data.index						= {if !empty($a_field.index)}{$a_field.index}{else}undefined{/if};
	o_data.UITypeNum					= {$a_field.UITypeNum};
	o_data.UITypeName					= '{addslashes($a_field.UITypeName)}';
	o_data.UITypeDBType					= o_data.UITypeNum == 7 && $("input[name='numeric_type']:checked").val() != 'I' ? 'DECIMAL(25,3)' : $("input[name='column_type']").val();
	o_data.UITypeDataType				= o_data.UITypeNum == 7 ? $("input[name='numeric_type']:checked").val() : '{addslashes($a_field.UITypeDataType)}';
	o_data.twoColumns					= {if $a_field.twoColumns}true{else}false{/if};
	o_data.fieldName					= $("input[name='field_name']").val();
	o_data.oldFieldName					= '{addslashes($a_field.fieldName)}';
	o_data.label						= $("input[name='label']").val();
	o_data.columnName					= $("input[name='column_name']").val();
	o_data.tableName					= $("input[name='table_name']").val();
	o_data.helpInfoLabel				= $("input[name='help_info_label']").val() != 'LBL_' ? $("input[name='help_info_label']").val() : '';
	o_data.defaultValue					= o_data.UITypeNum != 5 && o_data.UITypeNum != 6 && o_data.UITypeNum != 23 ? $("input[name='default_value']").val() : '';
	o_data.generatedType				= o_data.UITypeNum == 5 || o_data.UITypeNum == 6 || o_data.UITypeNum == 23 ? $("input[name='generated_type']:checked").val() : 1;
	o_data.displayType					= $("input[name='display_type']:checked").val();
	o_data.mandatory					= $("input[name='mandatory']").attr("checked") == "checked";
	o_data.isEntityIdentifier			= $("input[name='is_entity_identifier']").attr("checked") == "checked";
	o_data.entityIdentifierFieldName	= o_data.isEntityIdentifier ? $("input[name='entity_identifier_fieldname']").val() : '';
	o_data.inFilterAll					= $("input[name='in_filter_all']").attr("checked") == "checked";
	o_data.inPopup						= $("input[name='in_popup']").attr("checked") == "checked";
	o_data.popupSequence                = $("input[name='popupSequence']").val();
	o_data.inRelatedList				= $("input[name='in_related_list']").attr("checked") == "checked";
	o_data.relatedListSequence          = $("input[name='relatedListSequence']").val();
	o_data.quickCreate					= $("input[name='quick_create']").attr("checked") == "checked";
	o_data.massEditable					= $("input[name='mass_editable']").attr("checked") == "checked";
	o_data.readOnly						= $("input[name='read_only']").attr("checked") == "checked";
	o_data.relatedModule				= o_data.UITypeNum == 10 ? $("*[name='related_modules\\[\\]']").map(function(){ldelim}return $(this).val();{rdelim}).get() : undefined;
	o_data.addRelatedList				= o_data.UITypeNum == 10 ? $("*[name='add_related_list\\[\\]']").map(function(){ldelim}return $(this).is(":checked");{rdelim}).get() : undefined;
	o_data.pickListValues				= o_data.UITypeNum == 15 || o_data.UITypeNum == 16 || o_data.UITypeNum == 33 ? $("input[name='picklist_values']").val() : undefined;

	//Not allow "name" as fieldname
	if(o_data.fieldName == 'name')
	{
		alert(window.parent.md_vtranslate("LBL_VTIGER_DOESNT_LIKE_NAME"));
		return false;
	}

	//Not allow several fields as identifier
	if(o_data.isEntityIdentifier)
	{
		if(window.parent.md_entityIdentifier != undefined &&
			window.parent.md_entityIdentifier.length > 0 &&
			window.parent.md_entityIdentifier != o_data.oldFieldName)

		{
			alert(window.parent.md_vtranslate("LBL_NOT_POSSIBLE_TO_HAVE_SEVERAL_FIELDS_AS_IDENTIFIER"));
			return false;
		}
		else
		{
			window.parent.md_entityIdentifier = o_data.fieldName;
		}
	}
	else
	{
		if(window.parent.md_entityIdentifier == o_data.oldFieldName)
		{
			window.parent.md_entityIdentifier = undefined;
		}
	}

	if(o_data.UITypeNum == 10)
	{
		o_data.relatedModule = deleteCustomValues(o_data.relatedModule);
	}

{foreach item=language from=$a_languages}
	o_data.label_{$language} = $("input[name='label-{$language}']").val();
{/foreach}

{foreach item=language from=$a_languages}
	o_data.helpInfoLabel_{$language} = $("input[name='help-info-label-{$language}']").val();
{/foreach}

	var valid = false;
	var field = '';

	if(o_data.label == '' || o_data.label == 'LBL_')
		field = '{addslashes(vtranslate("LBL_FIELD_LABEL", $QUALIFIED_MODULE))}';
{foreach item=language from=$a_languages}
	else if('{$language}' == window.parent.defaultLanguage && o_data.label_{$language} == '')
		field = '{addslashes(vtranslate("LBL_FIELD_LABEL_TRANSLATION", $QUALIFIED_MODULE)|cat:' '|cat:$language)}';
{/foreach}
else if(o_data.isEntityIdentifier && o_data.entityIdentifierFieldName == '')
	field = '{addslashes(vtranslate('LBL_FIELD_ENTITY_IDENTIFIER', $QUALIFIED_MODULE))}';
{foreach item=language from=$a_languages}
	else if('{$language}' == window.parent.defaultLanguage && o_data.helpInfoLabel != '' && o_data.helpInfoLabel_{$language}  == '')
		field = '{addslashes(vtranslate('LBL_FIELD_HELP_INFO_LABEL_TRANSLATION', $QUALIFIED_MODULE))} {$language}';
{/foreach}
	else if((o_data.UITypeNum == 15 || o_data.UITypeNum == 16 || o_data.UITypeNum == 33) && (o_data.pickListValues == ''))
        field = '{addslashes(vtranslate('LBL_OPTIONS', $QUALIFIED_MODULE))}';
    else
		valid = true;

	if(!valid)
		alert("{vtranslate('LBL_FIELD_VALUE_HAS_TO_BE_DEFINED', $QUALIFIED_MODULE)} "+field);
	else
	{ldelim}
		window.parent.md_addField(o_data, false);
		window.parent.md_closePopup();
	{rdelim}
{rdelim}
</script>
</body>
</html>
