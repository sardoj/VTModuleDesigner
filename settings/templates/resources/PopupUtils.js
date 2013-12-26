function md_setLabel(input, labelFieldName, prefix)
{
	if (!prefix) { prefix = ''; } 
	
	var value = $(input).val().toUpperCase().replace(/[^0-9A-Z]/g, '_');
	
	if(value.search(prefix) == -1)
	{
		value = prefix+value;
	}
	
	$("input[name='"+labelFieldName+"']").val(value);
}

function md_setFieldName(input, entityIdentifierFieldName)
{	
	var value = $(input).val().toLowerCase().replace(/[^0-9a-z]/g, '_');
	$(input).val(value);
	
	$("input[name='"+entityIdentifierFieldName+"']").val(value);
}

function md_showOrHidenEntityIdentifierFieldName(cb, entityIdentifierFieldName)
{
	if($(cb).attr("checked") == "checked")
	{
		$("input[name='"+entityIdentifierFieldName+"']").show();
		$("#"+entityIdentifierFieldName).show();
		
		$("input[name='"+entityIdentifierFieldName+"']").focus();
	}
	else
	{
		$("input[name='"+entityIdentifierFieldName+"']").hide();
		$("#"+entityIdentifierFieldName).hide();
	}
}

function md_setEntityIdentifierFieldName(input)
{
	var value = $(input).val().toLowerCase().replace(/[^0-9a-z,_]/g, '');
	$(input).val(value);
}

function md_showOrHideHelpInfoTranslation(input, prefix, className)
{
	if($(input).val() != '' && $(input).val() != prefix)
	{
		$("."+className).show();
	}
	else
	{
		$("."+className).hide();
	}
}
