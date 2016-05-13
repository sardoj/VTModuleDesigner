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
<type>extension</type>
<version><?php echo $o_module->version; ?></version>
<dependencies>
<vtiger_version>6.0.0</vtiger_version>
</dependencies>
<?php if(count($o_module->a_customLinks) > 0): ?>
<customlinks>
<?php foreach($o_module->a_customLinks as $o_customLink): ?>
<customlink>
<linktype><?php echo $o_customLink->type; ?></linktype>
<linklabel><?php echo $o_customLink->label; ?></linklabel>
<linkurl><![CDATA[<?php echo $o_customLink->url; ?>]]></linkurl>
<linkicon><![CDATA[<?php echo $o_customLink->icon; ?>]]></linkicon>
<sequence><?php echo $o_customLink->index; ?></sequence>
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
<crons>
</crons>
</module>
