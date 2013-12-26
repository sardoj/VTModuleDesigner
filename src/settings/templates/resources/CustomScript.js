function md_customHandler(o_data)
{
	//Modify this script and "/vlayouts/layout/Settings/ModuleDesigner/Custom.tpl" to modify o_data variable
	o_data.myVariable = jQuery("select[name='myVariable']").val();
	
	return o_data;
}

function md_LoadModuleCustom(o_module)
{
	//Modify "/modules/ModuleDesigner/CustomManifestStructure.php" file to change this value;
	
	jQuery("select[name='myVariable']").val(o_module.myVariable);
}