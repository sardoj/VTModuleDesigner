<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="layouts/vlayout/modules/Settings/{$MODULE}/resources/PopupUtils.js"></script>
<script type="text/javascript" src="libraries/jquery/jquery.min.js"></script>
<script type="text/javascript" src="layouts/vlayout/modules/Settings/{$MODULE}/resources/jqueryCaret.js"></script>
</head>

<body>
<div style="font-family: Arial,Verdana,'Times New Roman',sans-serif;">
<h2>{vtranslate('LBL_EVENT', $QUALIFIED_MODULE)} - {vtranslate($a_event.eventName, $QUALIFIED_MODULE)}</h2>

<table id="form" style="font-size:12px;">
<tr>
	<td colspan="2"><h3>{vtranslate("LBL_EVENT_DESCRIPTION", $QUALIFIED_MODULE)}</h3></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/handler-path.png" alt="{vtranslate("LBL_EVENT_HANDLER_PATH_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_EVENT_HANDLER_PATH", $QUALIFIED_MODULE)}</td>
	<td><input type="text" name="handler_path" size="50" value="{$a_event.handlerPath}" /></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/handler-class.png" alt="{vtranslate("LBL_EVENT_HANDLER_CLASS_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_EVENT_HANDLER_CLASS", $QUALIFIED_MODULE)}</td>
	<td><input type="text" name="handler_class" size="50" value="{$a_event.handlerClass}" /></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/cond.png" alt="{vtranslate("LBL_EVENT_COND_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_EVENT_COND", $QUALIFIED_MODULE)}</td>
	<td><input type="text" name="cond" size="50" value="{$a_event.cond}" /></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/dependent.png" alt="{vtranslate("LBL_EVENT_DEPENDENT_ON_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_EVENT_DEPENDENT_ON", $QUALIFIED_MODULE)}</td>
	<td><input type="text" name="dependent_on" size="50" value="{$a_event.dependentOn}" /></td>
</tr>
<tr>
	<td><img src="layouts/vlayout/modules/Settings/{$MODULE}/assets/images/active.png" alt="{vtranslate("LBL_EVENT_IS_ACTIVE_ALT", $QUALIFIED_MODULE)}" /> {vtranslate("LBL_EVENT_IS_ACTIVE", $QUALIFIED_MODULE)}</td>
	<td><input type="checkbox" name="is_active" value="1" {if $a_event.isActive }checked="checked"{/if} /></td>
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
	o_data.id				= {if !empty($a_event.id)}'{$a_event.id}'{else}undefined{/if};
	o_data.index			= {if !empty($a_event.index)}{$a_event.index}{else}undefined{/if};
	o_data.eventName		= '{$a_event.eventName}';
	o_data.handlerPath		= $("input[name='handler_path']").val();
	o_data.handlerClass		= $("input[name='handler_class']").val();
	o_data.cond				= $("input[name='cond']").val();
	o_data.dependentOn		= $("input[name='dependent_on']").val();
	o_data.isActive			= $("input[name='is_active']").attr("checked") == "checked";

	var valid = false;
	var field = '';

	if(o_data.handlerPath == '')
		field = '{addslashes(vtranslate("LBL_EVENT_HANDLER_PATH", $QUALIFIED_MODULE))}';
	else if(o_data.handlerClass == '')
		field = '{addslashes(vtranslate("LBL_EVENT_HANDLER_CLASS", $QUALIFIED_MODULE))}';
	else
		valid = true;

	if(!valid)
		alert("{vtranslate('LBL_FIELD_VALUE_HAS_TO_BE_DEFINED', $QUALIFIED_MODULE)} "+field);
	else
	{ldelim}
		window.parent.md_addEvent(o_data, false);
		window.parent.md_closePopup();
	{rdelim}
{rdelim}
</script>
</body>
</html>