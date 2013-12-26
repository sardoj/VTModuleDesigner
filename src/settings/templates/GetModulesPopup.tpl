<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="layouts/vlayout/modules/Settings/{$MODULE}/resources/PopupUtils.js"></script>
</head>

<body>
<div style="font-family: Arial,Verdana,'Times New Roman',sans-serif;">
<h2>{vtranslate('LBL_MODULES', $QUALIFIED_MODULE)}</h2>

<table style="font-size:12px;">
{foreach item=module from=$LIST_MODULES}
<tr><td><a href="javascript:md_selectModule('{$module.name}')">{$module.tablabel}</a></td><td>{vtranslate($module.tablabel, $QUALIFIED_MODULE)}</td></tr>
{/foreach}
</table>
</div>

<script type="text/javascript">
function md_selectModule(moduleName)
{
	//window.parent.md_selectDirectoryTemplate(undefined, moduleName);
	window.parent.md_loadModule(moduleName)
	window.parent.md_closePopup();
}
</script>
</body>
</html>