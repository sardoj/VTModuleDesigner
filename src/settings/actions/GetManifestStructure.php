<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

define("DIR_TEMP", "cache/tempModuleDesigner/");
 
class Settings_ModuleDesigner_GetManifestStructure_Action extends Settings_Vtiger_Index_Action
{
	protected $a_translations;
	protected $moduleBaseDir;
	
	public function process(Vtiger_Request $request)
	{
	 	$error_code = '';
	 	$error_message = '';
		$success = true;
		
        if(!$request->get('mod') && !$request->get('path'))
		{
			$error_code = 'error-param';
			$error_message = getTranslatedString("LBL_ERROR_PARAM", $moduleName);
			$success = false;
		}
		
		//Get module's structure from manifest file
		if($request->get("mod"))
		{
			$o_module = $this->getStructureFromExistantModule($request->get("mod"));
		}
		elseif($request->get("path"))
		{
			$o_module = $this->getStructureFromZipPackage($request->get("path"));
		}
		
		//Make JSON response
		$response = new Vtiger_Response();
		if(!$success)
		{
        	$response->setError($error_code, $error_message);
		}
		else
        {
        	$response->setResult(array('module'	=> $o_module, 'basedir' => $this->moduleBaseDir));
		}
        $response->emit();
    }
	 
	protected function getStructureFromExistantModule($moduleName)
	{
		$this->moduleBaseDir = '';
		
		$manifest_filePath = $this->getManifestFilePath($moduleName, false);
			
		$xml_manifest = $this->getManifestContent($manifest_filePath);
				
		$this->getTranslations($moduleName);		
		
		$o_module = $this->getModuleObject($moduleName, $xml_manifest);
				
		return $o_module;
	}
	
	protected function getStructureFromZipPackage($filePath)
	{			
		$manifest_filePath = $this->getManifestFilePath($filePath, true);
			
		$xml_manifest = $this->getManifestContent($manifest_filePath);
				
		$moduleName = $this->getModuleName($xml_manifest);
		
		$this->getTranslations($moduleName, $filePath);		
		
		$o_module = $this->getModuleObject($moduleName, $xml_manifest);
				
		return $o_module;
	}
	
	protected function getManifestFilePath($moduleNameOrPackageFilePath, $isPackage=false)
	{
		$manifest_filePath = null;
		
		if(!$isPackage)
		{
			$manifest_filePath = $this->exportModule($moduleNameOrPackageFilePath);
		}
		else
		{
			$unzip = new Vtiger_Unzip($moduleNameOrPackageFilePath, true);
						
			$dirname = mktime();
			
			if(!is_dir(DIR_TEMP.$dirname))
			{
				mkdir(DIR_TEMP.$dirname);
			}
			
			$unzip->unzipAll(DIR_TEMP.$dirname, "", true, 0770);			
			
			if($unzip)
			{
				$manifest_filePath = DIR_TEMP.$dirname.'/manifest.xml';
				
				$this->moduleBaseDir = DIR_TEMP.$dirname.'/';
				
				$unzip->close();
			}
			
		}
		
		return $manifest_filePath;
	}
	
	protected function getManifestContent($manifestFilePath)
	{
		$xml_manifestContent = null;
		
		if(file_exists($manifestFilePath))
		{
			$xml_manifestContent = file_get_contents($manifestFilePath);
		}
		
		return $xml_manifestContent;
	}
	
	protected function getModuleName($xml_manifest)
	{
		$xml_manifest = html_entity_decode($xml_manifest, ENT_QUOTES, "utf-8");
		$xml_manifest = str_replace("&amp;", "&", $xml_manifest); //Because there can be both & and &amp; in XML file
		$xml_manifest = str_replace("&", "&amp;", $xml_manifest);
		
		$xml_module = new SimpleXMLElement($xml_manifest);
		
		return (String) $xml_module->name;
	}
	
	protected function exportModule($moduleName)
	{
		$manifest_filePath = false;
		
		$moduleInstance = Vtiger_Module::getInstance($moduleName);		
		if(!empty($moduleInstance))
		{
			require_once("vtlib/Vtiger/PackageExport.php");	
			$export = new Vtiger_PackageExport();
			$export->__initExport($moduleName, $moduleInstance);
			$export->export_Module($moduleInstance);
			$export->__finishExport();
			
			$manifest_filePath = $export->__getManifestFilePath();
		}
		
		return $manifest_filePath;
	}
	
	protected function getTranslations($moduleName)
	{
		$this->a_translations = array();
		
		//Vtiger 6
		if(is_dir($this->moduleBaseDir."languages"))
		{
			$dirname = $this->moduleBaseDir."languages/";
			$languages_dir = opendir($dirname);
		}
		//Vtiger 5
		elseif(is_dir($this->moduleBaseDir."modules/$moduleName/language"))
		{
			$dirname = $this->moduleBaseDir."modules/$moduleName/language/";
			$languages_dir = opendir($dirname);
		}
		
		if(!empty($languages_dir))
		{
			while($file = readdir($languages_dir))
			{
				if($file != '.' && $file != '..')
				{
					//Vtiger 5
					if(preg_match('`([a-z]+_[a-z]+)\.lang\.php$`', $file, $matches))
					{
						$language = $matches[1];
											
						include_once($dirname.$file);
						
						if(!empty($mod_strings))
						{
							$this->a_translations[$language] = $mod_strings; //$mod_strings is defined in the included file
						}
					}
					//Vtiger 6
					elseif(is_dir($dirname.$file) && preg_match('`([a-z]+_[a-z]+)$`', $file, $matches))
					{
						$language = $matches[1];
										
						//Open xx_yy locale directory
						$locale_dir = opendir($dirname.$file);												
						while($locale_file = readdir($locale_dir))
						{
							if($locale_file != '.' && $locale_file != '..')
							{
								//If a translation file exists for the module, add the language to the list
								if($locale_file == $moduleName.'.php')
								{
									include_once($dirname.$file.'/'.$locale_file);
						
									if(!empty($languageStrings))
									{
										$this->a_translations[$language] = $languageStrings; //$languageStrings is defined in the included file
									}
								}
							}
						}						
						
						closedir($locale_dir);		
					}
				}
			}

			closedir($languages_dir);
		}
	}
	
	protected function getModuleObject($moduleName, $xml_manifest)
	{
		$xml_manifest = html_entity_decode($xml_manifest, ENT_QUOTES, "utf-8");
		$xml_manifest = str_replace("&amp;", "&", $xml_manifest); //Because there can be both & and &amp; in XML file
		$xml_manifest = str_replace("&", "&amp;", $xml_manifest);
		
		$xml_module = new SimpleXMLElement($xml_manifest);
		
		$o_module = new stdClass();			
		$o_module->name = (String) $xml_module->name;
		$o_module->label = (String) $xml_module->label;		
		$o_module->parent = (String) $xml_module->parent;
		$o_module->version = (String) $xml_module->version;
		$o_module->type = !empty($xml_module->type) ? (String) $xml_module->type : 'module';
				
		$this->getModuleTranslatedLabel($o_module);
		
		$this->getBlocks($xml_module, $o_module);
		$this->getCustomLinks($xml_module, $o_module);
		$this->getRelatedLists($xml_module, $o_module);
		$this->getEvents($xml_module, $o_module);
		//$this->getFilterAll($xml_module, $o_module);
		
		$this->getModuleDefaultTable($moduleName, $o_module);
		$this->getPopupFieldsSequence($moduleName, $o_module);
		$this->getRelatedListFieldsSequence($moduleName, $o_module);
		
		
		
		global $currentModule;
		require_once("modules/$currentModule/CustomManifestStructure.php");		
		
		return $o_module;
	}
	
	protected function getModuleTranslatedLabel(&$o_module)
	{
		//Translations
		if(!empty($this->a_translations))
		{
			foreach($this->a_translations as $language => $translation)
			{			
				if(!empty($translation[$o_module->label]))
				{
					$o_module->{'label_'.$language} = $translation[$o_module->label];
					$o_module->{'label_single_'.$language} = $translation['SINGLE_'.$o_module->label];
					
				}
				else
				{
					$o_module->{'label_'.$language} = '';
					$o_module->{'label_single_'.$language} = '';
				}
			}
		}
	}
	
	protected function getBlocks($xml_module, &$o_module)
	{
		$o_module->a_blocks = array();
		$o_module->a_fields = array();
			
		$block_index = 0;
		
		if(empty($xml_module->blocks->block))
		{
			return false;
		}
		
		foreach($xml_module->blocks->block as $xml_block)
		{
			if($xml_block->label == 'LBL_CUSTOM_INFORMATION')
			{
				continue;
			}
			
			if(empty($xml_block->fields->field))
			{
				continue;
			}
			
			$o_block = new stdClass();
			$o_block->id			= "md-block-".$block_index;
			$o_block->label			= (String) $xml_block->label;
			$o_block->index			= (Int) $xml_block->sequence;
			$o_block->showTitle		= $xml_block->show_title == 1;
			$o_block->visible		= $xml_block->visible == 1;
			$o_block->createView	= $xml_block->create_view == 1;
			$o_block->editView		= $xml_block->edit_view == 1;
			$o_block->detailView	= $xml_block->detail_view == 1;
			$o_block->displayStatus	= $xml_block->display_status == 1;
			$o_block->isCustom		= $xml_block->iscustom == 1;
			$o_block->isList		= $xml_block->islist == 1;
			
			//Translations
			if(!empty($this->a_translations))
			{
				foreach($this->a_translations as $language => $translation)
				{			
					if(!empty($translation[$o_block->label]))
					{
						$o_block->{'label_'.$language} = $translation[$o_block->label];
						
					}
					else
					{
						$o_block->{'label_'.$language} = '';
					}
				}
			}
			
			$o_module->a_blocks[] = $o_block;
			
			$this->getBlockFields($xml_module, $xml_block, $block_index, $o_module);
		
			$block_index++;
		}
	}

	protected function getBlockFields($xml_module, $xml_block, $block_index, &$o_module)
	{
		$field_index = 0;
		foreach($xml_block->fields->field as $xml_field)
		{		
			$o_field = new stdClass();
			$o_field->id						= "md-field-".$block_index."-".$field_index;
			$o_field->index						= (Int) $xml_field->sequence;
			$o_field->UITypeNum					= (Int) $xml_field->uitype;
			$o_field->UITypeDataType			= (String) preg_replace('`~.+$`', '', $xml_field->typeofdata);
			$o_field->UITypeDBType				= (String) $xml_field->columntype;
			$o_field->fieldName					= (String) $xml_field->fieldname;
			$o_field->label						= (String) $xml_field->fieldlabel;
			$o_field->tableName					= (String) $xml_field->tablename;
			$o_field->columnName				= (String) $xml_field->columnname;
			$o_field->helpInfoLabel				= (String) $xml_field->helpinfo;
			$o_field->defaultValue				= (String) $xml_field->defaultvalue;
			$o_field->generatedType				= (Int) $xml_field->generatedtype;
			$o_field->displayType				= (Int) $xml_field->displaytype;
			$o_field->mandatory					= preg_match('`~M$`', $xml_field->typeofdata);
			$o_field->isEntityIdentifier		= !empty($xml_field->entityidentifier);
			$o_field->entityIdentifierFieldName	= !empty($xml_field->entityidentifier->fieldname) ? (String) $xml_field->entityidentifier->fieldname : '';
			$o_field->quickCreate				= $xml_field->quickcreate == 1;
			$o_field->massEditable				= $xml_field->masseditable == 1;
			$o_field->readOnly					= $xml_field->readonly == 2;
			
			//Vtiger 5 compability
			if($o_field->fieldName == 'CreatedTime' || $o_field->fieldName == 'ModifiedTime')
			{
				$o_field->fieldName = strtolower($o_field->fieldName);
			}
			
			if(!empty($xml_field->relatedmodules->relatedmodule))
			{
				$relatedModules_array = $this->sx_array($xml_field->relatedmodules);
				$relatedModules_array = $relatedModules_array["relatedmodule"];
				
				$o_field->relatedModule = $relatedModules_array;
			}
			
			
			if(!empty($xml_field->picklistvalues->picklistvalue))//MODIF by DavidV 2013-01-12
			{
				$picklistvalues_array = $this->sx_array($xml_field->picklistvalues);
			}
			
			$o_field->pickListValues = !empty($picklistvalues_array['picklistvalue']) && is_array($picklistvalues_array['picklistvalue']) ? implode(",", $picklistvalues_array['picklistvalue']) : null;//MODIF by DavidV 2013-01-12
			
			//UIType
			global $currentModule;
			require("modules/$currentModule/UITypes.php");
			
			if(!empty($a_uitypes))
			{
				foreach($a_uitypes as $uitype)
				{
					if($uitype["num"] == $o_field->UITypeNum)
					{
						$o_field->UITypeName = $uitype["label"];
						
						if($o_field->UITypeNum == 7 && $o_field->UITypeDataType != 'I')
						{
							$o_field->UITypeDBType = 'DECIMAL(25,3)';
						}
						else
						{
							$o_field->UITypeDBType = $uitype["dbtype"];
						}
						
						// $o_field->UITypeDataType = $uitype["datatype"];	//MODIF BY JonathanS 2013-04-17 : Commenté car pose des problèmes pour uitype 7 avec décimal
						break;
					}
				}
			}
			
			//In Filter All
			$o_field->inFilterAll = false;
			foreach($xml_module->customviews->customview->fields->field as $field)
			{
				if($field->fieldname == $o_field->fieldName)
				{
					$o_field->inFilterAll = true;
					break;
				}
			}
					
			//Translations
			if(!empty($this->a_translations))
			{
				foreach($this->a_translations as $language => $translation)
				{
					//Field label					
					if(!empty($translation[$o_field->label]))
					{
						$o_field->{'label_'.$language} = $translation[$o_field->label];
					}
					else
					{
						$o_field->{'label_'.$language} = '';
					}
					
					//Field help info
					if(!empty($o_field->helpInfoLabel) && !empty($translation[$o_field->helpInfoLabel]))
					{
						$o_field->{'helpInfoLabel_'.$language} = $translation[$o_field->helpInfoLabel];
					}
					elseif(!empty($o_field->helpInfoLabel))
					{
						$o_field->{'helpInfoLabel_'.$language} = '';
					}
				}
			}
			
			$o_module->a_fields[] = $o_field;
						
			$field_index++;
		}
	}

	protected function getCustomLinks($xml_module, &$o_module)
	{
		$o_module->a_customLinks = array();
		
		if(empty($xml_module->customlinks->customlink))
		{
			return false;
		}
		
		//Custom Links
		$customLink_index = 0;
		if (isset($xml_module->customlinks->customlink)) 
		{
		    foreach($xml_module->customlinks->customlink as $xml_customLink)
		    {
		    	$o_customLink 				= new stdClass();
		    	$o_customLink->id			= "md-custom-link-".$customLink_index;
		    	$o_customLink->index		= (Int) $xml_customLink->sequence;
		    	$o_customLink->type			= (String) $xml_customLink->linktype;
		    	$o_customLink->label		= (String) $xml_customLink->linklabel;
		    	$o_customLink->url			= (String) $xml_customLink->linkurl;
		    	$o_customLink->icon			= (String) $xml_customLink->linkicon;
		    	$o_customLink->handlerPath	= (String) $xml_customLink->handler_path;
		    	$o_customLink->handlerClass	= (String) $xml_customLink->handler_class;
		    	$o_customLink->handler		= (String) $xml_customLink->handler;
		    	
		    	//Translations
		    	if(!empty($this->a_translations))
		    	{
		    		foreach($this->a_translations as $language => $translation)
		    		{
		    			//Custom Link label					
		    			if(!empty($translation[$o_customLink->label]))
		    			{
		    				$o_customLink->{'label_'.$language} = $translation[$o_customLink->label];
		    			}
		    			else
		    			{
		    				$o_customLink->{'label_'.$language} = '';
		    			}
		    		}
		    	}
		    	
		    	$o_module->a_customLinks[] = $o_customLink;
		    	
		    	$customLink_index++;
		    }
		}
	}

	protected function getRelatedLists($xml_module, &$o_module)
	{
		$o_module->a_relatedLists = array();
		
		if(empty($xml_module->relatedlists->relatedlist))
		{
			return false;
		}
		
		//Related Lists
		$relatedList_index = 0;
		if (isset($xml_module->relatedlists->relatedlist)) 
		{
		    foreach($xml_module->relatedlists->relatedlist as $xml_relatedList)
		    {
		    	$o_relatedList					= new stdClass();
		    	$o_relatedList->id				= "md-related-list-".$relatedList_index;
		    	$o_relatedList->index			= (Int) $xml_relatedList->sequence;
		    	$o_relatedList->relatedModule	= (String) $xml_relatedList->relatedmodule;
		    	$o_relatedList->label			= (String) $xml_relatedList->label;
		    	$o_relatedList->functionName	= (String) $xml_relatedList->function;
		    	$o_relatedList->presence		= (Int) $xml_relatedList->presence;
		    	$o_relatedList->actionAdd		= false;
		    	$o_relatedList->actionSelect	= false;
		    	$o_relatedList->presence		= 1;
		    	
		    	//Related list actions
		    	if(!empty($xml_relatedList->actions->action))//MODIF by DavidV 2013-01-12
		    	{
		    		$actions_array = $this->sx_array($xml_relatedList->actions);//MODIF by DavidV 2013-01-12
		    		$actions_array = $actions_array["action"];
		    			
		    		if(is_array($actions_array))
		    		{
		    			foreach($actions_array as $action)
		    			{
		    				if((String) $action == 'ADD')
		    				{
		    					$o_relatedList->actionAdd = true;
		    				}
		    				elseif((String) $action == 'SELECT')
		    				{
		    					$o_relatedList->actionSelect = true;
		    				}
		    			}
		    		}
		    		else
		    		{
		    			if($actions_array == 'ADD')
		    			{
		    				$o_relatedList->actionAdd = true;
		    			}
		    			elseif($actions_array == 'SELECT')
		    			{
		    				$o_relatedList->actionSelect = true;
		    			}
		    		}
		    	}
		    		
		    	//Translations
		    	if(!empty($this->a_translations))
		    	{
		    		foreach($this->a_translations as $language => $translation)
		    		{
		    			//Custom Link label					
		    			if(!empty($translation[$o_relatedList->label]))
		    			{
		    				$o_relatedList->{'label_'.$language} = $translation[$o_relatedList->label];
		    			}
		    			else
		    			{
		    				$o_relatedList->{'label_'.$language} = '';
		    			}
		    		}
		    	}
		    	
		    	$o_module->a_relatedLists[] = $o_relatedList;
		    	
		    	$relatedList_index++;
		    }
		}
	}

	protected function getEvents($xml_module, &$o_module)
	{
		$o_module->a_events = array();
		
		if(empty($xml_module->events->event))
		{
			return false;
		}
		
		//Events
		if(!empty($xml_module->events->event))
		{
			$event_index = 0;
			foreach($xml_module->events->event as $xml_event)
			{
				$o_event				= new stdClass();
				$o_event->id			= "md-event-".$event_index;
				$o_event->index			= (Int) $xml_relatedList->sequence;	
				$o_event->eventName		= (String) $xml_event->eventname;
				$o_event->handlerPath	= (String) $xml_event->filename;
				$o_event->handlerClass	= (String) $xml_event->classname;
				$o_event->cond			= (String) $xml_event->condition;
				$o_event->dependentOn	= '';
				$o_event->isActive		= true;
				
				$o_module->a_events[] = $o_event;
				
				$event_index++;
			}
		}	
	}
	
	protected function getFilterAll($xml_module, &$o_module)
	{
		$o_module->a_filterAll = array();
		
		if(empty($xml_module->customviews->customview))
		{
			return false;
		}
		
		//Filter All
		foreach($xml_module->customviews->customview as $customview)
		{
			if($customview->viewname == 'All')
			{			
				foreach($customview->fields->field as $field)
				{
					$o_module->a_filterAll[] = (String) $field->fieldname;
				}
			}
		}
	}
	
	protected function getModuleDefaultTable($moduleName, $o_module)
	{
		$o_module->defaultTable = "vtiger_".strtolower($moduleName);
			
		if(file_exists($this->moduleBaseDir."modules/$moduleName/$moduleName.php"))
		{
		    require_once($this->moduleBaseDir."modules/$moduleName/$moduleName.php");
		    
		    $focus = new $moduleName();
		    
			if(!empty($focus->table_name))
			{
		    	$o_module->defaultTable = $focus->table_name;
			}
		}
	}
	
	protected function getPopupFieldsSequence($moduleName, $o_module)
	{
		$popupSequence = 0;
		//Popup Listview
		if(file_exists($this->moduleBaseDir."modules/$moduleName/$moduleName.php"))
		{
		    require_once($this->moduleBaseDir."modules/$moduleName/$moduleName.php");
		    
		    $focus = new $moduleName();
		                
		    //In Popup
		    //$o_field->inPopup = false;
		    
			if(!empty($focus->search_fields))
			{
			    foreach ($focus->search_fields as $search_field)
			    {
			    	if(!empty($o_module->a_fields))
					{					
				        foreach($o_module->a_fields as &$field) 
				        {
				            if(strtolower($search_field[0]) == strtolower($o_module->name) && strtolower($search_field[1]) == strtolower($field->fieldName))
				            {
				                $field->inPopup = true;
				                $field->popupSequence = $popupSequence++;
				                break;
				            }
				        }
					}      
				} 
		    }
		}
	}
	
	protected function getRelatedListFieldsSequence($moduleName, $o_module)
	{		
		$relatedListSequence = 0;
		//Related lists listview
		if(file_exists($this->moduleBaseDir."modules/$moduleName/$moduleName.php"))
		{
		    require_once($this->moduleBaseDir."modules/$moduleName/$moduleName.php");
		    
		    $focus = new $moduleName();
		                
		    
		    //In Related List
		    //$o_field->inRelatedList = false;
		    
			if(!empty($focus->list_fields))
			{
			    foreach ($focus->list_fields as $list_fields)
			    {
			    	if(!empty($o_module->a_fields))
					{
				        foreach ($o_module->a_fields as &$field) 
				        {
				            if(strtolower($list_fields[0]) == strtolower($o_module->name) && strtolower($list_fields[1]) == strtolower($field->fieldName))
				            {
				                $field->inRelatedList = true;
				                $field->relatedListSequence = $relatedListSequence++;
				                break;
				            }        
				        }
					}
			    }
			}
		}
	}
	
	protected function sx_array($obj)
	{
	    $arr = (array)$obj;
	    if(empty($arr)){
	        $arr = "";
	    } else {
	        foreach($arr as $key=>$value){
	            if(!is_scalar($value)){
	                $arr[$key] = $this->sx_array($value);
	            }
	        }
	    }
	    return $arr;
	}
}
