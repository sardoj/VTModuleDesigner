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

$module_language_dir = DIR_TEMP.$dirname.'/languages/';

$a_languages = explode(",", $o_module->languages);

$a_translations = array();

//On prépare les fichiers de langue pour les traitements futurs
foreach($a_languages as $language)
{
	$error = false;
		
	//Vtiger 5
	if(file_exists($module_dir.'language/'.$language.'.lang.php'))
	{
		$translation_file = $module_dir.'language/'.$language.'.lang.php';
	}
	//Vtiger 6
	elseif(file_exists($module_language_dir.$language.'/'.$o_module->name.'.php'))
	{
		$translation_file = $module_language_dir.$language.'/'.$o_module->name.'.php';
	}
	else
	{
		$error = true;
	}
	
	if(!$error)
	{
		$a_translations[$language] = array();
		
		//Module label translation
		$a_translations[$language][$o_module->label] = $o_module->{'label_'.$language};
		$a_translations[$language]["SINGLE_".$o_module->label] = $o_module->{'label_single_'.$language};
		
		//Blocks label translation
		foreach($o_module->a_blocks as $o_block)
		{
			$a_translations[$language][$o_block->label] = $o_block->{'label_'.$language};
		}
		
		//Fields label translation
		foreach($o_module->a_fields as $o_field)
		{
			//Fields assigned_user_id, createdtime and modifiedtime are translated in Vtiger global translation file
			if($o_field->fieldName != 'assigned_user_id' && $o_field->fieldName != 'createdtime' && $o_field->fieldName != 'modifiedtime')
			{
				$a_translations[$language][$o_field->label] = $o_field->{'label_'.$language};
			}
			
			if(!empty($o_field->helpInfoLabel))
			{
				$a_translations[$language][$o_field->helpInfoLabel] = $o_field->{'helpInfoLabel_'.$language};
			}
		}
		
		//CustomLinks label translation
		foreach($o_module->a_customLinks as $o_customLink)
		{
			$a_translations[$language][$o_customLink->label] = $o_customLink->{'label_'.$language};
		}
		
		//RelatedLists label translation
		foreach($o_module->a_relatedLists as $o_relatedList)
		{
			$a_translations[$language][$o_relatedList->label] = $o_relatedList->{'label_'.$language};
		}
		
		
		$language_txt = file_get_contents($translation_file);
		if(!preg_match('`%%%TRANSLATION%%%`', $language_txt))
		{
			include_once($translation_file);
			
			if(empty($languageStrings) && !empty($mod_strings)) //Vtiger 5
			{
				$languageStrings = $mod_strings;
			}
			
			foreach($languageStrings as $label => $translation)
			{			
				if(!array_key_exists($label, $a_translations[$language]))
				{
					$a_translations[$language][$label] = $translation;
				}
			}
		}
		
		
		$language_txt = file_get_contents($translation_file);
		$language_txt = preg_replace
					(
						array
						(
							//Vtiger 5
							'`\$mod_strings[^)]+\);`',
							//Vtiger 6
							'`\$languageStrings[^)]+\);`'
						),
						array
						(
							//Vtiger 5
							"\$mod_strings = array(\n%%%TRANSLATION%%%\n);",
							//Vtiger 6
							"\$languageStrings = array(\n%%%TRANSLATION%%%\n);"
						),
						$language_txt
					);
		file_put_contents($translation_file, $language_txt);
	}
}

//Generate translation files
foreach($a_languages as $language)
{
	$error = false;
		
	//Vtiger 5
	if(file_exists($module_dir.'language/'.$language.'.lang.php'))
	{
		$translation_file = $module_dir.'language/'.$language.'.lang.php';
	}
	//Vtiger 6
	elseif(file_exists($module_language_dir.$language.'/'.$o_module->name.'.php'))
	{
		$translation_file = $module_language_dir.$language.'/'.$o_module->name.'.php';
	}
	else
	{
		$error = true;
	}
	
	if(!$error)
	{	
		$translations = '';	
		
		foreach($a_translations[$language] as $label => $translation)
		{
			$translations .= "	'".addslashes($label)."' => '".addslashes($translation)."',\r\n";
		}

		$translation_feed = file_get_contents($translation_file);
		$translation_feed = str_replace('%%%TRANSLATION%%%', $translations, $translation_feed);
		file_put_contents($translation_file, $translation_feed);
	}
}