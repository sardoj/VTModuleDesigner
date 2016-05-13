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

$a_uitypes = array
(
array('num'=>1, 	'label'=>'Text input',					'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>2, 	'label'=>'Text input Mandatory',		'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>true,		'two_columns'=>false),
array('num'=>3,		'label'=>'Auto increment',				'dbtype'=>'INT(11)',		'datatype'=>'I',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>4,		'label'=>'Auto number',					'dbtype'=>'VARCHAR(32)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>5, 	'label'=>'Date',						'dbtype'=>'DATE',			'datatype'=>'D',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>6, 	'label'=>'Date time',					'dbtype'=>'TIMESTAMP NULL',	'datatype'=>'DT',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>7,		'label'=>'Numeric input',				'dbtype'=>'INT(11)',		'datatype'=>'I',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>8,		'label'=>'Json array',					'dbtype'=>'VARCHAR(512)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>9,		'label'=>'Percentage input',			'dbtype'=>'DECIMAL(25,3)',	'datatype'=>'N',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>10,	'label'=>'Related module',				'dbtype'=>'INT(19)',		'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>11,	'label'=>'Text input not verified',		'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>12,	'label'=>'Email system',				'dbtype'=>'VARCHAR(128)',	'datatype'=>'E',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>13,	'label'=>'Email input',					'dbtype'=>'VARCHAR(128)',	'datatype'=>'E',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>15,	'label'=>'Pick list securised',			'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>16,	'label'=>'Pick list',					'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>17,	'label'=>'URL',							'dbtype'=>'VARCHAR(256)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>19, 	'label'=>'Text area',					'dbtype'=>'TEXT',			'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>true),
array('num'=>20, 	'label'=>'Text area mandatory',			'dbtype'=>'TEXT',			'datatype'=>'V',	'mandatory'=>true,		'two_columns'=>true),
array('num'=>21, 	'label'=>'Text area small',				'dbtype'=>'VARCHAR(512)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>22, 	'label'=>'Title',						'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>23, 	'label'=>'Date end',					'dbtype'=>'DATE',			'datatype'=>'D',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>24, 	'label'=>'Address',						'dbtype'=>'VARCHAR(255)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>25, 	'label'=>'Email Status Tracking',		'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>26, 	'label'=>'Documents folder',			'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>27, 	'label'=>'File type information',		'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>28, 	'label'=>'Filename holder',				'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>30, 	'label'=>'Reminder time',				'dbtype'=>'TIMESTAMP NULL',	'datatype'=>'DT',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>33, 	'label'=>'Pick list multiple',			'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>51, 	'label'=>'Account',						'dbtype'=>'INT(11)',		'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>52, 	'label'=>'Dropdown combo input',		'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>53, 	'label'=>'Dropdown combo radiobutton',	'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>55, 	'label'=>'Salutation and Firstname',	'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>56, 	'label'=>'Boolean',						'dbtype'=>'VARCHAR(5)',		'datatype'=>'C',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>57, 	'label'=>'Contact',						'dbtype'=>'INT(11)',		'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>69, 	'label'=>'Image',						'dbtype'=>'VARCHAR(256)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>70, 	'label'=>'Date Time',					'dbtype'=>'DATETIME',		'datatype'=>'D',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>71, 	'label'=>'Currency',					'dbtype'=>'DECIMAL(25,3)',	'datatype'=>'N',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>72, 	'label'=>'Amount',						'dbtype'=>'DECIMAL(25,8)',	'datatype'=>'N',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>73, 	'label'=>'Account',						'dbtype'=>'INT(11)',		'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>76, 	'label'=>'Potential',					'dbtype'=>'INT(11)',		'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>77, 	'label'=>'User',						'dbtype'=>'INT(11)',		'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>83, 	'label'=>'Tax',							'dbtype'=>'DECIMAL(7,3)',	'datatype'=>'N',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>117, 	'label'=>'Currency name',				'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),
array('num'=>255, 	'label'=>'Salutation auto',				'dbtype'=>'VARCHAR(128)',	'datatype'=>'V',	'mandatory'=>false,		'two_columns'=>false),


);

?>
