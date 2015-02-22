<?php
/***********************************************************************************
 * "The contents of this file are subject to the vtiger Public License Version 1.2 
 * (the "License"); you may not use this file except in compliance with the License."
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations 
 * under the License.
 * The Original Code is Module Designer.
 * The Initial Developer of the Original Code is Jonathan SARDO. 
 * Portions created by Jonathan SARDO are Copyright (C).
 * All Rights Reserved.
 ************************************************************************************/
?>
<?php echo '<?xml version="1.0"?>'; ?>

<module>
<exporttime><?php echo date("Y-m-d H:i:s"); ?></exporttime>
<name><?php echo $o_module->name; ?></name>
<label><?php echo $o_module->label; ?></label>
<parent><?php echo $o_module->parentTab; ?></parent>
<version><?php echo $o_module->version; ?></version>
<dependencies>
<vtiger_version>6.0.0</vtiger_version>
</dependencies>
<tables>
<?php if(!empty($o_module->a_usedTables)): ?>
<?php foreach($o_module->a_usedTables as $tableName): ?>
<?php if($tableName == 'vtiger_crmentity'){continue;} ?>
<table>
<name><?php echo $tableName; ?></name>
<sql><![CDATA[CREATE TABLE `<?php echo $tableName; ?>` (
  <?php if(!empty($o_module->a_tableNameIndexes[$tableName])): ?>
  `<?php echo $o_module->a_tableNameIndexes[$tableName]; ?>` int(11) NOT NULL DEFAULT '0',
  <?php else: ?>
  `<?php echo $o_module->lowerName; ?>id` int(11) NOT NULL DEFAULT '0',
  <?php endif; ?>
  <?php foreach($o_module->a_fields as $o_field): ?><?php if(empty($o_field->tableName) || $o_field->tableName == $tableName): ?>
  `<?php echo $o_field->fieldName; ?>` <?php echo $o_field->UITypeDBType; ?> DEFAULT NULL,
  <?php endif; ?><?php endforeach; ?>
  <?php if(!empty($o_module->a_tableNameIndexes[$tableName])): ?>
  PRIMARY KEY (`<?php echo $o_module->a_tableNameIndexes[$tableName]; ?>`)
  <?php else: ?>
  PRIMARY KEY (`<?php echo $o_module->lowerName; ?>id`)
  <?php endif; ?>
) ENGINE=InnoDB DEFAULT CHARSET=utf8]]></sql>
</table>
<?php endforeach; ?>
<?php else: ?>
<table>
<name>vtiger_<?php echo $o_module->lowerName; ?></name>
<sql><![CDATA[CREATE TABLE `vtiger_<?php echo $o_module->lowerName; ?>` (
  `<?php echo $o_module->lowerName; ?>id` int(11) NOT NULL DEFAULT '0',
  <?php foreach($o_module->a_fields as $o_field): ?><?php if(empty($o_field->tableName) || $o_field->tableName == 'vtiger_'.$o_module->lowerName): ?>
  `<?php echo $o_field->fieldName; ?>` <?php echo $o_field->UITypeDBType; ?> DEFAULT NULL,
  <?php endif; ?><?php endforeach; ?>
  PRIMARY KEY (`<?php echo $o_module->lowerName; ?>id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8]]></sql>
</table>
<?php endif; ?>
<?php $cfTableName = !empty($o_module->customFieldTable) ? $o_module->customFieldTable : 'vtiger_'.$o_module->lowerName.'cf'; ?>
<?php  
	if(!empty($o_module->customFieldTableIndex))
	{
		$cfTableIndex = $o_module->customFieldTableIndex;
	}
	elseif(!empty($o_module->a_tableNameIndexes[$cfTableName]))
	{
		$cfTableIndex = $o_module->a_tableNameIndexes[$cfTableName];
	}
	else
	{
		$cfTableIndex = $o_module->lowerName.'id';
	}
?>
<?php if(!in_array($cfTableName, $o_module->a_usedTables)): ?>
<table>
<name><?php echo $cfTableName; ?></name>
<sql><![CDATA[CREATE TABLE `<?php echo $cfTableName; ?>` (
  `<?php echo $cfTableIndex; ?>` int(11) NOT NULL,
  PRIMARY KEY (`<?php echo $cfTableIndex; ?>`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8]]></sql>
</table>
<?php endif; ?>
</tables>
<blocks>
<?php foreach($o_module->a_blocks as $i_block => $o_block): ?>
<?php $block_id = str_replace("md-block-", "", $o_block->id); ?>
<block>
<label><?php echo str_replace("&", "&amp;", $o_block->label); ?></label>
<sequence><?php echo $i_block+1; ?></sequence>
<show_title><?php echo $o_block->showTitle ? 1 : 0; ?></show_title>
<visible><?php echo $o_block->visible ? 1 : 0; ?></visible>
<create_view><?php echo $o_block->createView ? 1 : 0; ?></create_view>
<edit_view><?php echo $o_block->editView ? 1 : 0; ?></edit_view>
<detail_view><?php echo $o_block->detailView ? 1 : 0; ?></detail_view>
<display_status><?php echo $o_block->displayStatus ? 1 : 0; ?></display_status>
<iscustom><?php echo $o_block->isCustom ? 1 : 0; ?></iscustom>
<islist><?php echo $o_block->isList ? 1 : 0; ?></islist>
<fields>
<?php foreach($o_module->a_fields as $i_field => $o_field): ?>
<?php if(preg_match('`md-field-'.$block_id.'-[0-9]+`', $o_field->id)): ?>
<field>
<fieldname><?php echo $o_field->fieldName; ?></fieldname>
<uitype><?php echo $o_field->UITypeNum; ?></uitype>
<columnname><?php echo $o_field->columnName; ?></columnname>
<columntype><?php echo $o_field->UITypeDBType; ?></columntype>
<tablename><?php echo !empty($o_field->tableName) ? $o_field->tableName : 'vtiger_'.$o_module->lowerName; ?></tablename>
<generatedtype><?php echo $o_field->generatedType; ?></generatedtype>
<fieldlabel><?php echo str_replace("&", "&amp;", $o_field->label); ?></fieldlabel>
<readonly><?php echo $o_field->readOnly ? 2 : 1; ?></readonly>
<presence>2</presence>
<defaultvalue><?php echo $o_field->defaultValue; ?></defaultvalue>
<sequence><?php echo $o_field->index; ?></sequence>
<maximumlength>100</maximumlength>
<typeofdata><?php echo $o_field->UITypeDataType; ?>~<?php echo $o_field->mandatory ? 'M' : 'O'; ?></typeofdata>
<quickcreate><?php echo $o_field->quickCreate ? 0 : 1; ?></quickcreate>
<quickcreatesequence></quickcreatesequence>
<displaytype><?php echo $o_field->displayType; ?></displaytype>
<info_type>BAS</info_type>
<helpinfo><![CDATA[<?php echo $o_field->helpInfoLabel; ?>]]></helpinfo>
<masseditable><?php echo $o_field->massEditable ? 1 : 0; ?></masseditable>
<?php if($o_field->UITypeNum == 10): ?>
<relatedmodules>
<?php if(is_array($o_field->relatedModule)): ?>
<?php foreach($o_field->relatedModule as $relatedModule): ?>
<relatedmodule><?php echo trim($relatedModule); ?></relatedmodule>
<?php endforeach; ?>
<?php else: ?>
<relatedmodule><?php echo trim($o_field->relatedModule); ?></relatedmodule>
<?php endif; ?>
</relatedmodules>
<?php elseif(in_array($o_field->UITypeNum, array(15,16,33))): ?>
<?php $a_pickListValues = explode(",", $o_field->pickListValues); ?>
<picklistvalues>
<?php foreach($a_pickListValues as $value): ?>
<?php $value = trim($value); ?>
<?php if(!empty($value)): ?>
<picklistvalue><?php echo $value; ?></picklistvalue>
<?php endif; ?>
<?php endforeach; ?>
</picklistvalues>
<?php endif; ?>
<?php if($o_field->isEntityIdentifier): ?>
<entityidentifier>
<?php 
	if(!empty($o_module->a_tableNameIndexes[$o_module->defaultTable]))
	{
		$entityIdField = $o_module->a_tableNameIndexes[$o_module->defaultTable];
		$entityIdColumn = $entityIdField;
	}
	else
	{
		$entityIdField = $o_module->lowerName.'id';
		$entityIdColumn = $entityIdField;
	}
?>
<fieldname><?php echo $o_field->entityIdentifierFieldName; ?></fieldname>
<entityidfield><?php echo $entityIdField; ?></entityidfield>
<entityidcolumn><?php echo $entityIdColumn; ?></entityidcolumn>
</entityidentifier>
<?php endif; ?>
</field>
<?php endif; ?>
<?php endforeach; ?>
</fields>
</block>
<?php endforeach; ?>
</blocks>
<customviews>
<?php foreach($o_module->a_filters as $i_filter=>$o_filter): ?>
<customview>
<viewname><?php echo $o_filter->name; ?></viewname>
<setdefault><?php echo $i_filter == 0 ? 'true' : 'false'; ?></setdefault>
<setmetrics>false</setmetrics>
<fields>
<?php foreach($o_filter->a_fields as $i_filter=> $o_field): ?>
<field>
<fieldname><?php echo $o_field; ?></fieldname>
<columnindex><?php echo $i_filter+1; ?></columnindex>
</field>
<?php endforeach; ?>
</fields>
</customview>
<?php endforeach; ?>
</customviews>
<sharingaccess>
<default>public_readwritedelete</default>
</sharingaccess>
<?php if(count($o_module->a_customLinks) > 0): ?>
<customlinks>
<?php foreach($o_module->a_customLinks as $i_customLink => $o_customLink): ?>
<customlink>
<linktype><?php echo $o_customLink->type; ?></linktype>
<linklabel><?php echo $o_customLink->label; ?></linklabel>
<linkurl><![CDATA[<?php echo $o_customLink->url; ?>]]></linkurl>
<linkicon><![CDATA[<?php echo $o_customLink->icon; ?>]]></linkicon>
<sequence><?php echo $i_customLink+1; ?></sequence>
<handler_path><![CDATA[<?php echo $o_customLink->handlerPath; ?>]]></handler_path>
<handler_class><![CDATA[<?php echo $o_customLink->handlerClass; ?>]]></handler_class>
<handler><![CDATA[<?php echo $o_customLink->handler; ?>]]></handler>
</customlink>
<?php endforeach; ?>
</customlinks>
<?php endif; ?>
<?php if(count($o_module->a_events) > 0): ?>
<events>
<?php foreach($o_module->a_events as $o_event): ?>
<event>
<eventname><?php echo $o_event->eventName; ?></eventname>
<classname><![CDATA[<?php echo $o_event->handlerClass; ?>]]></classname>
<filename><![CDATA[<?php echo $o_event->handlerPath; ?>]]></filename>
<condition><![CDATA[<?php echo $o_event->cond; ?>]]></condition>
</event>
<?php endforeach; ?>
</events>
<?php endif; ?>
<actions>
<action>
<name><![CDATA[Import]]></name>
<status>disabled</status>
</action>
<action>
<name><![CDATA[Export]]></name>
<status>disabled</status>
</action>
<action>
<name><![CDATA[Merge]]></name>
<status>disabled</status>
</action>
</actions>
<?php if(count($o_module->a_relatedLists) > 0): ?>
<relatedlists>
<?php foreach($o_module->a_relatedLists as $i_relatedList => $o_relatedList): ?>
<relatedlist>
<function><?php echo $o_relatedList->functionName; ?></function>
<label><?php echo $o_relatedList->label; ?></label>
<sequence><?php echo $i_relatedList+1; ?></sequence>
<presence><?php echo $o_relatedList->presence; ?></presence>
<actions>
<?php if($o_relatedList->actionSelect): ?>
<action>SELECT</action>
<?php endif; ?>
<?php if($o_relatedList->actionAdd): ?>
<action>ADD</action>
<?php endif; ?>
</actions>
<relatedmodule><?php echo $o_relatedList->relatedModule; ?></relatedmodule>
</relatedlist>
<?php endforeach; ?>
</relatedlists>
<?php endif; ?>
<crons>
</crons>
</module>
