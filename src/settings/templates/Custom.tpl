<script type="text/javascript" src="layouts/vlayout/modules/Settings/{$MODULE}/resources/CustomScript.js"></script>

<h2>{vtranslate('LBL_CUSTOM_VALUES', $QUALIFIED_MODULE)}</h2>

<table>
<tr>
<td colspan="2">
{vtranslate('LBL_CUSTOM_VALUES_DESCRIPTION', $QUALIFIED_MODULE)}
</td>
</tr>
<tr>
<td>{vtranslate('LBL_MY_VARIABLE', $QUALIFIED_MODULE)}</td>
<td>
<select name="myVariable">
<option value="value1">{vtranslate('LBL_MY_VALUE', $QUALIFIED_MODULE)} 1</option>
<option value="value2">{vtranslate('LBL_MY_VALUE', $QUALIFIED_MODULE)} 2</option>
</select>
</td>
</tr>
</table>