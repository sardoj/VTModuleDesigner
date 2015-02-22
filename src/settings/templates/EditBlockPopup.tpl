<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="layouts/vlayout/modules/Settings/{$MODULE}/resources/PopupUtils.js"></script>
<script type="text/javascript" src="libraries/jquery/jquery.min.js"></script>
<script type="text/javascript" src="layouts/vlayout/modules/Settings/{$MODULE}/resources/jqueryCaret.js"></script>
</head>

<body>
<div style="font-family: Arial,Verdana,'Times New Roman',sans-serif;">
<h2>{vtranslate("LBL_BLOCK", $QUALIFIED_MODULE)}</h2>

<table id="form" style="font-size:12px;">
<tr><td colspan="2"><h3>{vtranslate("LBL_BLOCK_DESCRIPTION", $QUALIFIED_MODULE)}</h3></td></tr>
<tr><td>{vtranslate("LBL_BLOCK_LABEL", $QUALIFIED_MODULE)}</td><td><input type="text" size="50" name="label" value="{if !empty($a_block.label)}{$a_block.label}{/if}" onkeyup="md_setLabel(this, 'label', 'LBL_')" /></td></tr>

{foreach item=language from=$a_languages}
{assign var="label" value="label_"|cat:$language}
<tr>
	<td>{vtranslate("LBL_BLOCK_LABEL_TRANSLATION", $QUALIFIED_MODULE)} <em>{$language}</em></td>
	<td colspan="2"><input type="text" name="label-{$language}" size="50" value="{if !empty($a_block.$label)}{$a_block.$label}{/if}" /></td>
</tr>
{/foreach}
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><h3>{vtranslate("LBL_BLOCK_OPTIONS", $QUALIFIED_MODULE)}</h3></td></tr>
<tr><td><input type="checkbox" name="show_title" {if !isset($a_block.showTitle) || $a_block.showTitle == 1}checked="checked"{/if} /> {vtranslate("LBL_BLOCK_SHOW_TITLE", $QUALIFIED_MODULE)}</td><td><input type="button" value="{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}" onclick="md_popupSave()" /></td></tr>
<tr><td colspan="2"><input type="checkbox" name="visible" {if !isset($a_block.visible) || $a_block.visible == 1}checked="checked"{/if} /> {vtranslate("LBL_BLOCK_VISIBLE", $QUALIFIED_MODULE)}</td></tr>
<tr><td colspan="2"><input type="checkbox" name="create_view" {if !empty($a_block.createView)}checked="checked"{/if} /> {vtranslate("LBL_BLOCK_CREATE_VIEW", $QUALIFIED_MODULE)}</td></tr>
<tr><td colspan="2"><input type="checkbox" name="edit_view" {if !empty($a_block.editView)}checked="checked"{/if} /> {vtranslate("LBL_BLOCK_EDIT_VIEW", $QUALIFIED_MODULE)}</td></tr>
<tr><td colspan="2"><input type="checkbox" name="detail_view" {if !empty($a_block.detailView)}checked="checked"{/if} /> {vtranslate("LBL_BLOCK_DETAIL_VIEW", $QUALIFIED_MODULE)}</td></tr>
<tr><td colspan="2"><input type="checkbox" name="display_status" {if !isset($a_block.displayStatus) || $a_block.displayStatus == 1}checked="checked"{/if} /> {vtranslate("LBL_BLOCK_DISPLAY_STATUS", $QUALIFIED_MODULE)}</td></tr>
<tr><td colspan="2"><input type="checkbox" name="is_custom" {if !empty($a_block.isCustom)}checked="checked"{/if} /> {vtranslate("LBL_BLOCK_IS_CUSTOM", $QUALIFIED_MODULE)}</td></tr>
<tr><td colspan="2"><input type="checkbox" name="is_list" {if !empty($a_block.isList)}checked="checked"{/if} /> {vtranslate("LBL_BLOCK_IS_LIST", $QUALIFIED_MODULE)}</td></tr>
</table>
</div>

<script type="text/javascript">
function md_popupSave()
{ldelim}
	var o_data = new Object();
	o_data.id				= {if !empty($a_block.id)}'{$a_block.id}'{else}'undefined'{/if};
	o_data.index			= {if !empty($a_block.index)}{$a_block.index}{else}'undefined'{/if};
	o_data.label			= $("input[name='label']").val();
	o_data.showTitle		= $("input[name='show_title']").attr("checked") == "checked";
	o_data.visible			= $("input[name='visible']").attr("checked") == "checked";
	o_data.createView		= $("input[name='create_view']").attr("checked") == "checked";
	o_data.editView			= $("input[name='edit_view']").attr("checked") == "checked";
	o_data.detailView		= $("input[name='detail_view']").attr("checked") == "checked";
	o_data.displayStatus	= $("input[name='display_status']").attr("checked") == "checked";
	o_data.isCustom			= $("input[name='is_custom']").attr("checked") == "checked";
	o_data.isList			= $("input[name='is_list']").attr("checked") == "checked";
	o_data.maxFieldId		= {if !empty($a_block.maxFieldId)}{$a_block.maxFieldId}{else}0{/if}

{foreach item=language from=$a_languages}
	o_data.label_{$language} = $("input[name='label-{$language}']").val();	
{/foreach}

	var valid = false;
	var field = '';

	if(o_data.label == '')
		field = '{addslashes(vtranslate("LBL_BLOCK_LABEL", $QUALIFIED_MODULE))}';
{foreach item=language from=$a_languages}
	else if('{$language}' == window.parent.defaultLanguage && o_data.label_{$language} == '')
		field = '{addslashes(vtranslate("LBL_BLOCK_LABEL_TRANSLATION", $QUALIFIED_MODULE)|cat:' '|cat:$language)}';
{/foreach}
	else
		valid = true;
	
	if(!valid)
		alert("{vtranslate('LBL_FIELD_VALUE_HAS_TO_BE_DEFINED', $QUALIFIED_MODULE)} "+field);
	else
	{ldelim}
		window.parent.md_editBlock(o_data);
		window.parent.md_closePopup();
	{rdelim}
{rdelim}
</script>
</body>
</html>