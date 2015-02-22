<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="layouts/vlayout/modules/Settings/{$MODULE}/resources/PopupUtils.js"></script>
<script type="text/javascript" src="libraries/jquery/jquery.min.js"></script>
<script type="text/javascript" src="layouts/vlayout/modules/Settings/{$MODULE}/resources/jqueryCaret.js"></script>
</head>

<body>
<div style="font-family: Arial,Verdana,'Times New Roman',sans-serif;">
<h2>{vtranslate('LBL_RELATED_LIST_LINK_TO_MODULE', $QUALIFIED_MODULE)} - {vtranslate($a_relatedList.relatedModule, $QUALIFIED_MODULE)}</h2>

<table id="form" style="font-size:12px;">
<tr>
	<td colspan="2"><h3>{vtranslate("LBL_RELATED_LIST_DESCRIPTION", $QUALIFIED_MODULE)}</h3></td>
</tr>
<tr>
	<td>{vtranslate("LBL_RELATED_LIST_LABEL", $QUALIFIED_MODULE)}</td>
	<td colspan="2"><input type="text" name="label" size="50" value="{if !empty($a_relatedList.label)}{$a_relatedList.label}{/if}" onkeyup="md_setLabel(this, 'label', '')" /></td>
</tr>
{foreach item=language from=$a_languages}
{assign var="label" value='label_'|cat:$language}
<tr>
	<td>{vtranslate("LBL_RELATED_LIST_LABEL_TRANSLATION", $QUALIFIED_MODULE)} <em>{$language}</em></td>
	<td><input type="text" name="label-{$language}" size="50" value="{if !empty($a_relatedList.$label)}{$a_relatedList.$label}{/if}" /></td>
</tr>
{/foreach}
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td style="vertical-align: top;">{vtranslate("LBL_RELATED_LIST_NAME", $QUALIFIED_MODULE)}</td>
	<td>
		<select name="name" onchange="setRelatedListName(this)">
			<option value="get_related_list" {if empty($a_relatedList.functionName) || $a_relatedList.functionName == 'get_related_list'}selected="selected"{/if}>get_related_list</option>
			<option value="get_dependents_list" {if $a_relatedList.functionName == 'get_dependents_list'}selected="selected"{/if}>get_dependents_list</option>
			<option value="get_attachments" {if $a_relatedList.functionName == 'get_attachments'}selected="selected"{/if}>get_attachments</option>
			<option value="get_history" {if $a_relatedList.functionName == 'get_history'}selected="selected"{/if}>get_history</option>
			<option value="CUSTOM" {if !empty($a_relatedList.functionName) && !in_array($a_relatedList.functionName, array('get_related_list', 'get_dependents_list', 'get_attachments', 'get_history'))}selected="selected"{/if}>{vtranslate("LBL_RELATED_LIST_CUSTOM_NAME", $QUALIFIED_MODULE)}</option>
		</select>
		<input type="text" name="custom_name" size="25" value="{if !in_array($a_relatedList.functionName, array('get_related_list', 'get_dependents_list', 'get_attachments', 'get_history'))}{$a_relatedList.functionName}{/if}" {if in_array($a_relatedList.functionName, array('', 'get_related_list', 'get_dependents_list', 'get_attachments', 'get_history'))}style="display: none;"{/if} />
	</td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/presence.png" alt="{vtranslate("LBL_RELATED_LIST_PRESENCE_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_RELATED_LIST_PRESENCE", $QUALIFIED_MODULE)}</td>
	<td><input type="checkbox" name="presence" value="1" {if $a_relatedList.presence == 1}checked="checked"{/if} /></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2"><h3>{vtranslate("LBL_RELATED_LIST_ACTIONS", $QUALIFIED_MODULE)}</h3></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/add.png" alt="{vtranslate("LBL_RELATED_LIST_ACTION_ADD_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_RELATED_LIST_ACTION_ADD", $QUALIFIED_MODULE)}</td>
	<td><input type="checkbox" name="action_add" value="1" {if $a_relatedList.actionAdd}checked="checked"{/if} /></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/select.png" alt="{vtranslate("LBL_RELATED_LIST_ACTION_SELECT_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_RELATED_LIST_ACTION_SELECT", $QUALIFIED_MODULE)}</td>
	<td><input type="checkbox" name="action_select" value="1"  {if $a_relatedList.actionSelect}checked="checked"{/if} /></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="button" onclick="md_popupSave();" value="{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}" /></td>
</tr>
</table>
</div>

<script type="text/javascript">
function md_popupSave()
{ldelim}
	var o_data = new Object();
	o_data.id				= {if !empty($a_relatedList.id)}'{$a_relatedList.id}'{else}undefined{/if};
	o_data.index			= {if !empty($a_relatedList.index)}{$a_relatedList.index}{else}undefined{/if};
	o_data.relatedModule	= '{$a_relatedList.relatedModule}';
	o_data.label			= $("input[name='label']").val();
	o_data.functionName		= $("select[name='name']").val() == 'CUSTOM' ? $("input[name='custom_name']").val() : $("select[name='name']").val();
	o_data.presence			= $("input[name='presence']").attr("checked") == "checked" ? 1 : 0;
	o_data.actionAdd		= $("input[name='action_add']").attr("checked") == "checked";
	o_data.actionSelect		= $("input[name='action_select']").attr("checked") == "checked";

{foreach item=language from=$a_languages}
	o_data.label_{$language} = $("input[name='label-{$language}']").val();	
{/foreach}
	
	var valid = false;
	var field = '';
	
	if(o_data.label == '' || o_data.label == 'LBL_')
		field = '{addslashes(vtranslate("LBL_RELATED_LIST_LABEL", $QUALIFIED_MODULE))}';
{foreach item=language from=$a_languages}
	else if('{$language}' == window.parent.defaultLanguage && o_data.label_{$language} == '')
		field = '{addslashes(vtranslate("LBL_RELATED_LIST_LABEL_TRANSLATION", $QUALIFIED_MODULE)|cat:' '|cat:$language)}';
{/foreach}
	else if(o_data.functionName == '')
		field = '{addslashes(vtranslate("LBL_RELATED_LIST_NAME", $QUALIFIED_MODULE))}';
	else
		valid = true;

	if(!valid)
		alert("{vtranslate('LBL_FIELD_VALUE_HAS_TO_BE_DEFINED', $QUALIFIED_MODULE)} "+field);
	else
	{ldelim}
		window.parent.md_addRelatedList(o_data, false);
		window.parent.md_closePopup();
	{rdelim}
{rdelim}

function setRelatedListName(cb)
{ldelim}
	if($(cb).val() == 'CUSTOM')
	{ldelim}
		$("input[name='custom_name']").show();
		$("input[name='custom_name']").focus();
	{rdelim}
	else
	{ldelim}
		$("input[name='custom_name']").hide();
	{rdelim}
{rdelim}
</script>
</body>
</html>