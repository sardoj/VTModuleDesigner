<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): Jonathan SARDO.
 * Portions created by Jonathan SARDO are Copyright (C).
 ************************************************************************************/

define("DIR_TEMP", "cache/tempModuleDesigner/");
 
class Settings_ModuleDesigner_MakePackage_Action extends Settings_Vtiger_Index_Action
{
	protected static $jsonFileName = "module_json.txt";
		
	 public function process(Vtiger_Request $request)
	 {
		//Make temp directory if it does not exist
		$this->makeTempDirectory();
		
		//Get base directory name
		$dirname = $this->getDirectoryName($request);
		
		//Get module object
		$o_module = $this->getModule($request);
		
		//Make directories
		$this->makeDirectories($dirname, $o_module->name);		
		
		//Get module directory
		$module_dir = $this->getModuleDirectory($dirname, $o_module);
		
		//Save JSON module structure
		$this->saveJsonStructure($dirname, $module_dir, $o_module);
		
		//Save XML Manifest
		$this->saveXmlManifest($dirname, $request->getModule(), $module_dir, $o_module);
		
		//Make module directory
		$this->makeModuleDirectory($dirname, $request->getModule(), $module_dir, $o_module);
				
		//Plugins handle
		$this->executePlugins($dirname, $module_dir, $request->getModule(), $o_module);
		
		//Create module zip package
		$zipfilename = $this->createZipPackage($dirname, $o_module);		
		
		//Make JSON response		
        $response = new Vtiger_Response();				
		if(!empty($zipfilename))
        {
        	$response->setResult(array('zipFileName' => $zipfilename));
		}
        $response->emit();
    }

	protected function makeTempDirectory()
	{
		//Make directories
		if(!is_dir(DIR_TEMP))
		{
			mkdir(DIR_TEMP);
			chmod(DIR_TEMP, 0755);
		}
	}
	
	protected function makeDirectories($dirname, $moduleName)
	{		
		mkdir(DIR_TEMP.$dirname);
		mkdir(DIR_TEMP.$dirname."/modules");
		mkdir(DIR_TEMP.$dirname."/modules/$moduleName");
	}
	
	protected function getModuleDirectory($dirname, $o_module)
	{
		return DIR_TEMP."{$dirname}/modules/{$o_module->name}/";
	} 
	
	protected function getDirectoryName(Vtiger_Request $request)
	{
		$dirname = false;
		
		if ($request->get('d'))
		{
			$dirname = $request->get('d');
		}
		else
		{
			$dirname = mktime();
		}
		
		return $dirname;
	}
	
	protected function getModule(Vtiger_Request $request)
	{
		$o_module = false;
		
		$dirname = $this->getDirectoryName($request);
		
		if ($request->get('d'))
		{
			$o_module = json_decode(file_get_contents(DIR_TEMP.$dirname."/".static::$jsonFileName));
		}
		else
		{
			$structure = stripslashes($_POST['structure']);
			$o_module = json_decode($structure);
		}
		
		$o_module->lowerName = strtolower($o_module->name);
		
		$this->sortModuleData($o_module);
		
		//Store all tables which are used
		$o_module->a_usedTables = array();
		
		foreach($o_module->a_fields as $i_field => $o_field)
		{
			if(!in_array($o_field->tableName, $o_module->a_usedTables))
			{
				$o_module->a_usedTables[] = $o_field->tableName;
			}
		}
		
		//Store all table indexes
		$this->getModuleTableNameIndexes($o_module->name, $o_module);
		
		//Store custom table data
		$this->getModuleCustomFieldTable($o_module->name, $o_module);
		
		return $o_module;
	}
	
	protected function sortModuleData(&$o_module)
	{
		usort($o_module->a_blocks, array(self, "cmp"));
		usort($o_module->a_fields, array(self, "cmp"));
		usort($o_module->a_relatedLists, array(self, "cmp"));
		usort($o_module->a_filters, array(self, "cmp"));
	}
	
	protected function saveJsonStructure($dirname, $module_dir, $o_module)
	{
		//Save JSON module structure
		file_put_contents(DIR_TEMP.static::$jsonFileName, json_encode($o_module));
		file_put_contents(DIR_TEMP.$dirname."/".static::$jsonFileName, json_encode($o_module));
	}
	
	protected function saveXmlManifest($dirname, $moduleName, $module_dir, $o_module)
	{		
		ob_start();
		include "modules/$moduleName/templates/{$o_module->manifestTemplate}";
		$xml_manifest = ob_get_clean();
		$xml_manifest = str_replace("&amp;", "&", $xml_manifest); //Because there can be both & and &amp; in XML file
		$xml_manifest = str_replace("&", "&amp;", $xml_manifest);
		$xml_manifest = preg_replace_callback('`<!\[CDATA\[(.+?)\]\]>`', array($this, 'replaceEncodedAndInCDATA'), $xml_manifest); //For Custom links
				
		file_put_contents(DIR_TEMP."{$dirname}/manifest.xml", $xml_manifest);
		
		//Also copy manifest in module directory
		//file_put_contents($module_dir."manifest.xml", $xml_manifest);
	}
		
	protected function makeModuleDirectory($dirname, $moduleName, $module_dir, $o_module)
	{
		//Make module directory
		if(empty($o_module->modifiedModule)) //Create
		{			
			$this->copyr("modules/$moduleName/templates/".$o_module->directoryTemplate, $module_dir);
				
			//Vtiger 5
			if(file_exists($module_dir.'ModuleFile.js'))
			{
				rename($module_dir.'ModuleFile.js', 				$module_dir.$o_module->name.'.js');
			}
			if(file_exists($module_dir.'ModuleFile.php'))
			{
				rename($module_dir.'ModuleFile.php', 				$module_dir.$o_module->name.'.php');
			}
			if(file_exists($module_dir.'ModuleFileAjax.php'))
			{
				rename($module_dir.'ModuleFileAjax.php', 			$module_dir.$o_module->name.'Ajax.php');
			}
			if(file_exists($module_dir.'ModuleFileEventHandler.php'))
			{
				rename($module_dir.'ModuleFileEventHandler.php',	$module_dir.$o_module->name.'EventHandler.php');
			}
			//Vtiger 6
			if(file_exists($module_dir.'ModuleName.php'))
			{
				rename($module_dir.'ModuleName.php',	$module_dir.$o_module->name.'.php');
			}
						
			
			$a_languages = explode(",", $o_module->languages);
			foreach($a_languages as $language)
			{
				if(file_exists($module_dir.'LANGUAGES/'.$language.'/ModuleName.php'))
				{
					rename($module_dir.'LANGUAGES/'.$language.'/ModuleName.php',	$module_dir.'LANGUAGES/'.$language.'/'.$o_module->name.'.php');
				}
			}

			$module_language_dir = DIR_TEMP.$dirname.'/languages/';
			
			if(is_dir($module_dir.'LANGUAGES'))
			{
				rename($module_dir.'LANGUAGES', $module_language_dir);
			}
		}
		else //Edit
		{	
			$this->copyr($o_module->modifiedModulePath."modules/".$o_module->modifiedModule, $module_dir);
			
			if(is_dir($o_module->modifiedModulePath.'templates'))
			{
				$this->copyr($o_module->modifiedModulePath.'templates', 	DIR_TEMP.$dirname.'/templates');
			}	
			//Vtiger 6
			elseif(is_dir("layouts/vlayout/modules/{$o_module->modifiedModule}"))
			{
				$this->copyr("layouts/vlayout/modules/{$o_module->modifiedModule}", DIR_TEMP.$dirname."/templates");
			}	
			//Vtiger 5	
			elseif(is_dir("Smarty/templates/modules/{$o_module->modifiedModule}"))
			{
				$this->copyr("Smarty/templates/modules/{$o_module->modifiedModule}", DIR_TEMP.$dirname."/templates");
			}
			
			//Settings MVC
			if(!empty($o_module->modifiedModulePath) && is_dir($o_module->modifiedModulePath.'settings'))
			{
				$this->copyr($o_module->modifiedModulePath.'settings', DIR_TEMP.$dirname."/settings");
			}
			elseif(empty($o_module->modifiedModulePath) && is_dir("modules/Settings/{$o_module->modifiedModule}"))
			{
				$this->copyr("modules/Settings/{$o_module->modifiedModule}", DIR_TEMP.$dirname."/settings");
			}
			
			//Settings templates (only if they was not already copied by copying settings directory)
			if(empty($o_module->modifiedModulePath) && !is_dir($o_module->modifiedModulePath.'settings/templates') && is_dir("layouts/vlayout/modules/Settings/{$o_module->modifiedModule}"))
			{
				$this->copyr("layouts/vlayout/modules/Settings/{$o_module->modifiedModule}", DIR_TEMP.$dirname."/settings/templates");
			}
			
			//Cron
			if(!empty($o_module->modifiedModulePath) && is_dir($o_module->modifiedModulePath.'cron'))
			{
				$this->copyr($o_module->modifiedModulePath.'cron', 	DIR_TEMP.$dirname."/cron");
			}
			elseif(empty($o_module->modifiedModulePath) && is_dir('cron/modules/'.$o_module->modifiedModule))
			{
				$this->copyr('cron/modules/'.$o_module->modifiedModule, 	DIR_TEMP.$dirname."/cron");
			}
			
			//Module image
			if(!empty($o_module->modifiedModulePath) && file_exists($o_module->modifiedModulePath.$o_module->modifiedModule.'.png'))
			{
				$this->copyr($o_module->modifiedModulePath.$o_module->modifiedModule.".png", 	DIR_TEMP.$dirname."/".$o_module->name.".png");
			}
			elseif(empty($o_module->modifiedModulePath) && file_exists('layouts/vlayout/skins/images/'.$o_module->modifiedModule.'.png'))
			{
				$this->copyr('layouts/vlayout/skins/images/'.$o_module->modifiedModule.'.png', 	DIR_TEMP.$dirname."/".$o_module->name.".png");
			}
			
			
			//Vtiger 6
			if(is_dir($o_module->modifiedModulePath.'languages'))
			{
				if(!empty($o_module->modifiedModulePath))
				{
					$this->copyr($o_module->modifiedModulePath.'languages', DIR_TEMP.$dirname."/languages", $o_module->modifiedModule.'.php', $o_module->name.'.php');
				}
				else
				{
					$this->copyLanguageFiles($dirname, $o_module->modifiedModule, $o_module->name);
				}
			}	
		
			if(file_exists($module_dir.$o_module->modifiedModule.'.js'))
			{
				rename($module_dir.$o_module->modifiedModule.'.js', 				$module_dir.$o_module->name.'.js');
			}
			if(file_exists($module_dir.$o_module->modifiedModule.'.php'))
			{
				rename($module_dir.$o_module->modifiedModule.'.php', 				$module_dir.$o_module->name.'.php');
			}
			if(file_exists($module_dir.$o_module->modifiedModule.'Ajax.php'))
			{
				rename($module_dir.$o_module->modifiedModule.'Ajax.php', 			$module_dir.$o_module->name.'Ajax.php');
			}
			if(file_exists($module_dir.$o_module->modifiedModule.'EventHandler.php'))
			{
				rename($module_dir.$o_module->modifiedModule.'EventHandler.php',	$module_dir.$o_module->name.'EventHandler.php');
			}
			
					
		
			//On prépare le fichier Module.php pour les traitements futurs
			$moduleClass_txt = file_get_contents($module_dir.$o_module->name.'.php');
			$moduleClass_txt = str_replace
						(
							array
							(
								'class '.$o_module->modifiedModule,
								'function '.$o_module->modifiedModule,
								strtolower($o_module->modifiedModule)
							),
							array
							(
								'class <ModuleName>',
								'function <ModuleName>',
								'payslip'
							),
							$moduleClass_txt
						);
						
			// if($o_module->directoryTemplate == '6.0.0')
			// {
				// $moduleClass_txt = str_replace('class '.$o_module->modifiedModule, 'class ModuleName', $moduleClass_txt);
			// }
			// else
			// {
				// $moduleClass_txt = str_replace('class '.$o_module->modifiedModule, 'class ModuleClass', $moduleClass_txt);
			// }
			
			$moduleClass_txt = preg_replace
								(
									array
									(
										'`\$list_fields_name[^)]+\);`',
										'`\$search_fields_name[^)]+\);`',
										'`\$list_fields[^_=]*=[^;]+;`',
										'`\$search_fields[^_=]*=[^;]+;`',
										'`\$list_link_field[^_=]*=[^;]+;`',
										'`\$popup_fields[^_=]*=[^;]+;`',
										'`\$def_basicsearch_col[^_=]*=[^;]+;`',
										'`\$def_detailview_recname[^_=]*=[^;]+;`',
										'`\$required_fields[^_=]*=[^;]+;`',
										'`\$default_order_by[^_=]*=[^;]+;`',
										'`\$mandatory_fields[^_=]*=[^;]+;`',
									),
									array
									(
										"\$list_fields_name = array (\n%%%RELATED_LIST_FIELDS_NAME%%%\n);",
										"\$search_fields_name = array (\n%%%POPUP_FIELDS_NAME%%%\n);",
										"\$list_fields = array (\n%%%RELATED_LIST_FIELDS%%%\n);",
										"\$search_fields = array (\n%%%POPUP_FIELDS%%%\n);",
										"\$list_link_field = 'payslipname';",
										"\$popup_fields = array('payslipname');", //TODO: Handle multi fields
										"\$def_basicsearch_col = 'payslipname';",
										"\$def_detailview_recname = 'payslipname';",
										"\$required_fields = array('payslipname'=>1);", //TODO: Handle multi fields
										"\$default_order_by = 'payslipname';",
										"\$mandatory_fields = array('createdtime', 'modifiedtime', 'payslipname');", //TODO: Handle multi fields or other fields
									),
									$moduleClass_txt
								);
								
			file_put_contents($module_dir.$o_module->name.'.php', $moduleClass_txt);
		}

		$related_list_fields = '';
		$related_list_fields_name = '';
		$popup_fields = '';
		$popup_fields_name = '';
		$identifier_field = '';
		
		//entity identifier
		foreach($o_module->a_fields as $o_field)
		{
			if($o_field->isEntityIdentifier)
			{
				$identifier_field = $o_field->fieldName;
			}
		}
		
		//Popup		
		usort($o_module->a_fields, array(self, "cmpPopup"));//Sort on popupsequence
		
		foreach($o_module->a_fields as $o_field)
		{
		    
		    if($o_field->inPopup)
		    {
		        $popup_fields .= "\t\t'{$o_field->label}' => array('".strtolower($o_module->name)."', '{$o_field->fieldName}'),\r\n";
		        $popup_fields_name .= "\t\t'{$o_field->label}' => '{$o_field->fieldName}',\r\n";
		    }
		
		}
		
		//Related List		
		usort($o_module->a_fields, array(self, "cmpRelatedList"));//Sort on relatedlistsequence
		
		foreach($o_module->a_fields as $o_field)
		{
		    if($o_field->inRelatedList)
		    {
		        $related_list_fields .= "\t\t'{$o_field->label}' => array('".strtolower($o_module->name)."', '{$o_field->fieldName}'),\r\n";
		        $related_list_fields_name .= "\t\t'{$o_field->label}' => '{$o_field->fieldName}',\r\n";
		    }
		}
		
		//Add Related List
		$a_relatedListToCreate = array();
		foreach($o_module->a_fields as $o_field)
		{
		    if(!empty($o_field->relatedModule) && is_array($o_field->relatedModule))
		    {
		    	foreach($o_field->relatedModule as $key => $relatedModule)
				{
					if($o_field->addRelatedList[$key])
					{	
						$relatedListStr = "\r\n".
											"\t\t\$moduleInstance = Vtiger_Module::getInstance('$relatedModule');\r\n".
											"\t\t\$relatedModuleInstance = Vtiger_Module::getInstance('$o_module->name');\r\n".
											"\t\t\$relationLabel = 'LBL_".strtoupper($o_module->name)."_LIST';\r\n".
											"\t\t\$moduleInstance->setRelatedList(\r\n".
											"\t\t\t\$relatedModuleInstance, \$relationLabel, array('ADD'), 'get_dependents_list'\r\n".
											"\t\t);\r\n";
						
						$a_relatedListToCreate[] = $relatedListStr;
					}
				}
		    }
		}
		$related_lists_to_create = implode("", $a_relatedListToCreate);
		
		
		$module_class_content = file_get_contents($module_dir.$o_module->name.'.php');
		$module_class_content = str_replace
			(
				array
				(
					//Vtiger 5
					'ModuleClass',
					'payslipname',
					'payslip',
					'Payslip',
					//Vtiger 6
					'<ModuleName>',
					'<modulename>',
					'<entityfieldname>',
					//Generic
					'%%%RELATED_LIST_FIELDS%%%',
					'%%%RELATED_LIST_FIELDS_NAME%%%',
					'%%%POPUP_FIELDS%%%',
					'%%%POPUP_FIELDS_NAME%%%',
					'%%%RELATED_LISTS_TO_CREATE%%%',
				),
				array
				(
					//Vtiger 5
					$o_module->name,
					$identifier_field,
					strtolower($o_module->name),
					$o_module->name,
					//Vtiger 6
					$o_module->name,
					strtolower($o_module->name),
					$identifier_field,
					//Generic
					$related_list_fields,
					$related_list_fields_name,
					$popup_fields,
					$popup_fields_name,
					$related_lists_to_create
				),
				$module_class_content
			);
			
		file_put_contents($module_dir.$o_module->name.'.php', $module_class_content);
	}

	protected function executePlugins($dirname, $module_dir, $moduleName, $o_module)
	{		
		//Plugins handle
		$plugins_dir_path = "modules/$moduleName/plugins/";
		$dir = opendir($plugins_dir_path);
		
		while($file = readdir($dir))
		{
			if($file != '.' && $file != '..')
			{
				include_once($plugins_dir_path."/".$file);
			}
		}
		closedir($dir);
	}

	/**
	 * Function copies language files to zip
	 * @param <Vtiger_Zip> $zip
	 * @param <String> $module
	 */
	protected function copyLanguageFiles($dirname, $module, $new_module_name=false) {
		$languageFolder = "languages";
		if($dir = @opendir($languageFolder)) {		// open languages folder
			while (($langName = readdir($dir)) !== false) {
				if ($langName != ".." && $langName != "." && is_dir($languageFolder."/".$langName)) {
					$langDir = @opendir($languageFolder. '/'.$langName);		//open languages/en_us folder
					while(($moduleLangFile = readdir($langDir))  !== false) {
						$langFilePath = $languageFolder.'/'.$langName.'/'.$moduleLangFile;
						if(is_file($langFilePath) && $moduleLangFile === $module.'.php') {	//check if languages/en_us/module.php file exists
							if(!is_dir(DIR_TEMP.$dirname.'/'.$languageFolder)){
								mkdir(DIR_TEMP.$dirname.'/'.$languageFolder);
							}
							if(!is_dir(DIR_TEMP.$dirname.'/'.$languageFolder.'/'.$langName)){
								mkdir(DIR_TEMP.$dirname.'/'.$languageFolder.'/'.$langName);
							}
							$this->copyr($langFilePath, 	DIR_TEMP.$dirname.'/'.$langFilePath, $module.'.php', $new_module_name.'.php');
						} else if(is_dir($langFilePath) && $moduleLangFile == 'Settings') {
							$settingsLangDir = @opendir($langFilePath);
							while($settingLangFileName = readdir($settingsLangDir)) {
								$settingsLangFilePath = $languageFolder.'/'.$langName.'/'.$moduleLangFile.'/'.$settingLangFileName;
								if(is_file($settingsLangFilePath) && $settingLangFileName === $module.'.php') {		//check if languages/en_us/Settings/module.php file exists
									if(!is_dir(DIR_TEMP.$dirname.'/'.$languageFolder)){
										mkdir(DIR_TEMP.$dirname.'/'.$languageFolder);
									}
									if(!is_dir(DIR_TEMP.$dirname.'/'.$languageFolder.'/'.$langName)){
										mkdir(DIR_TEMP.$dirname.'/'.$languageFolder.'/'.$langName);
									}
									if(!is_dir(DIR_TEMP.$dirname.'/'.$languageFolder.'/'.$langName.'/'.$moduleLangFile)){
										mkdir(DIR_TEMP.$dirname.'/'.$languageFolder.'/'.$langName.'/'.$moduleLangFile);
									}
									$this->copyr($settingsLangFilePath, DIR_TEMP.$dirname.'/'.$settingsLangFilePath, $module.'.php', $new_module_name.'.php');
								}
							}
							closedir($settingsLangDir);
						}
					}
					closedir($langDir);
			   }
		   }
		   closedir($dir);
		}
	}
	
	protected function createZipPackage($dirname, $o_module)
	{
		include_once('vtlib/Vtiger/Zip.php');
		
		$module = $o_module->name;
		
		// Export as Zip
		$zipfilename = DIR_TEMP.$dirname."/{$module}_" . date('Y-m-d') . "_{$o_module->version}.zip";
		$zip = new Vtiger_Zip($zipfilename);
		
		// Add manifest file
		$zip->addFile(DIR_TEMP."{$dirname}/manifest.xml","manifest.xml");
		$zip->copyDirectoryFromDisk(DIR_TEMP."{$dirname}/modules", "modules");
		if(is_dir(DIR_TEMP."{$dirname}/languages"))
		{
			$zip->copyDirectoryFromDisk(DIR_TEMP."{$dirname}/languages", "languages");
		}
		if(is_dir(DIR_TEMP."{$dirname}/templates"))
		{
			$zip->copyDirectoryFromDisk(DIR_TEMP."{$dirname}/templates", "templates");
		}
		if(is_dir(DIR_TEMP."{$dirname}/settings"))
		{
			$zip->copyDirectoryFromDisk(DIR_TEMP."{$dirname}/settings", "settings");
		}
		if(is_dir(DIR_TEMP."{$dirname}/cron"))
		{
			$zip->copyDirectoryFromDisk(DIR_TEMP."{$dirname}/cron", "cron");
		}
		if(file_exists(DIR_TEMP."{$dirname}/{$module}.png"))
		{
			$zip->addFile(DIR_TEMP."{$dirname}/{$module}.png", "{$module}.png");
		}
		$zip->save();
		
		//$zip->forceDownload($zipfilename);
		//unlink($zipfilename);
		
		return $zipfilename;
	}

	protected function getModuleTableNameIndexes($moduleName, $o_module)
	{
		$o_module->a_tableNameIndexes = array();
		
		if(file_exists($this->moduleBaseDir."modules/$moduleName/$moduleName.php"))
		{
		    require_once($this->moduleBaseDir."modules/$moduleName/$moduleName.php");
		    
		    $focus = new $moduleName();
		    
			if(!empty($focus->tab_name_index))
			{
		    	$o_module->a_tableNameIndexes = $focus->tab_name_index;
			}
		}
	}
	
	protected function getModuleCustomFieldTable($moduleName, $o_module)
	{
		$o_module->customFieldTable = null;
		$o_module->customFieldTableIndex = null;
		
		if(file_exists($this->moduleBaseDir."modules/$moduleName/$moduleName.php"))
		{
		    require_once($this->moduleBaseDir."modules/$moduleName/$moduleName.php");
		    
		    $focus = new $moduleName();
		    
			if(!empty($focus->customFieldTable))
			{
				$a_tables = array_keys($focus->customFieldTable);
				
		    	$o_module->customFieldTable = $a_tables[0];
          $o_module->customFieldTableIndex = $focus->customFieldTable[$a_tables[1]];
			}
		}
	}
	
	protected function copyr($source, $dest, $old_file_name=false, $new_file_name=false)
	{
	   // Simple copy for a file
	   if (is_file($source)) {
			if($old_file_name !== false && $new_file_name !== false){	   	
				$a_source = explode(DS, $source);
				$a_dest = explode(DS, $dest);
				
				if($a_source[count($a_source)-1] == $old_file_name){
					array_pop($a_dest);
					$a_dest[] = $new_file_name;
					$dest = implode(DS, $a_dest);
				}
			}

			$return = copy($source, $dest);
			chmod($dest, 0755);
			return $return;
	   }
	
	   // Make destination directory
	   if (!is_dir($dest)) {
	      mkdir($dest);
		  chmod($dest, 0755);
	      $company = ($_POST['company']);
	   }
	
	   // Loop through the folder
	   $dir = dir($source);
	   
	   while (false !== $entry = $dir->read()) {
	      // Skip pointers
	      if ($entry == '.' || $entry == '..') {
	         continue;
	      }
	
	      // Deep copy directories
	      if ($dest !== "$source/$entry") {
	         $this->copyr("$source/$entry", "$dest/$entry");
	      }
	   }
	
	   // Clean up
	   $dir->close();
	   return true;
	}
	
	//Sort blocks
	protected function cmp($a, $b)
	{
	    return $a->index - $b->index;
	}
	
	//Sort popup fields
	protected function cmpPopup($a, $b) 
	{
	    return $a->popupSequence - $b->popupSequence;
	}
	
	//Sort related list fields
	protected function cmpRelatedList($a, $b) 
	{
	    return $a->relatedListSequence - $b->relatedListSequence;
	}
	
	protected function replaceEncodedAndInCDATA($m) {
		return '<![CDATA[' . preg_replace("`&amp;`", '&', $m[1]) . ']]>';
	}
}	