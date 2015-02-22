<?php
/************************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): Jonathan SARDO.
 * Portions created by Jonathan SARDO are Copyright (C).
 *************************************************************************************/

class Settings_ModuleDesigner_EditField_View extends Settings_Vtiger_Index_View
{

	function preProcess(Vtiger_Request $request) {
		return;
	}

	function postProcess(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request)
	{	
		$GLOBALS['csrf']['frame-breaker'] = false;
		
		$viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		
		if((!$request->get("field") && !$request->get("uitype")) || !$request->get("mod") || !$request->get("languages"))
		{
			//Make JSON response		
	        $response = new Vtiger_Response();	
	        $response->setError('error-param', getTranslatedString("LBL_ERROR_PARAM", $moduleName));
	        $response->emit();
		}
		else
		{
			$languages = trim($request->get("languages"));
			$a_languages = explode(",", $languages);
			
			if($request->get("field"))
			{						
				$a_field =  $request->get("field");
							
				//Repair bug with utf8 characters
				if(!is_array($a_field))
				{					
					$oldValue = Zend_Json::$useBuiltinEncoderDecoder;
					Zend_Json::$useBuiltinEncoderDecoder = true;
					$a_field = Zend_Json::decode($a_field);
					Zend_Json::$useBuiltinEncoderDecoder = $oldValue;
					
					foreach($a_field as &$val)
					{
						if(is_string($val))
						{
							$val = utf8_encode($val);
						}
					}
				}
			}

			if(empty($a_field))
			{
				$a_field["fieldName"]					= '';
				$a_field["oldFieldName"]				= '';
				$a_field["label"]						= '';
				$a_field["tableName"]					= $this->getModuleDefaultTable($request->get('mod'));
				$a_field["columnName"]					= '';
				$a_field["helpInfoLabel"]				= '';
				$a_field["defaultValue"]				= '';
				$a_field["generatedType"]				= null;
				$a_field["displayType"]					= 1;
				$a_field["isEntityIdentifier"]			= false;
				$a_field["entityIdentifierFieldName"]	= '';
				$a_field["inFilterAll"]					= false;
				$a_field["inPopup"]						= false;
				$a_field["popupSequence"]				= '';
				$a_field["inRelatedList"]				= false;
				$a_field["relatedListSequence"]			= '';
				$a_field["quickCreate"]					= false;
				$a_field["massEditable"]				= false;
				$a_field["readOnly"]					= false;
				$a_field["relatedModule"]				= null;
				$a_field["pickListValues"]				= null;
				$a_field["addRelatedList"]				= null;
			
				foreach($a_languages as $language)
				{
					$a_field["label_".$language] = '';
				}
				
				foreach($a_languages as $language)
				{
					$a_field["helpInfoLabel_".$language] = '';
				}
				
				require_once("modules/$moduleName/UITypes.php");
	
				foreach($a_uitypes as $uitype)
				{
					if($uitype["num"] == $request->get("uitype"))
					{
						$a_field["UITypeNum"]		= $request->get("uitype");
						$a_field["UITypeName"]		= $uitype["label"];
						$a_field["UITypeDBType"]	= $uitype["dbtype"];
						$a_field["UITypeDataType"]	= $uitype["datatype"];
						$a_field["mandatory"]		= $uitype["mandatory"];
						$a_field["twoColumns"]		= $uitype["two_columns"];
						break;
					}
				}				
			}
			
			if($a_field["UITypeNum"] == 10)
			{
				if(empty($a_field["relatedModule"]))
				{
					$a_field["relatedModule"] = array('');
				}
				elseif(is_string($a_field["relatedModule"]))
				{
					$a_field["relatedModule"] = array($a_field["relatedModule"]);
				}
				
				if(empty($a_field))
				{
					$a_field["addRelatedList"] = true;
				}
			}
			
			//Get modules
			$db = PearDatabase::getInstance();
			
			$query = "SELECT tablabel FROM vtiger_tab ORDER BY tablabel ASC";
			$result = $db->pquery($query, array());
			
			$a_modules = array();
			while($row = $db->fetchByAssoc($result))
			{
				$a_modules[] = $row["tablabel"];
			}
			
			//Can show add related list option
			if($a_field["UITypeNum"] == 10 && $request->get('exist') == 0)
			{
				$canAddRelatedList = true;
			} 
			else
			{
				$canAddRelatedList = false;
			}
			
			$viewer->assign('MODULE', $moduleName);
			$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
			$viewer->assign('moduleName', $request->get('mod'));
			$viewer->assign('a_modules', $a_modules);
			$viewer->assign('a_field', $a_field);
			$viewer->assign('a_languages', $a_languages);
			$viewer->assign('CAN_ADD_RELATED_LIST', $canAddRelatedList);
			
			echo $viewer->view('EditFieldPopup.tpl', $qualifiedModuleName,true);
		}
	}
	
	protected function getModuleDefaultTable($moduleName)
	{
		$defaultTable = "vtiger_".strtolower($moduleName);
			
		if(file_exists($this->moduleBaseDir."modules/$moduleName/$moduleName.php"))
		{
		    require_once($this->moduleBaseDir."modules/$moduleName/$moduleName.php");
		    
		    $focus = new $moduleName();
		    
			if(!empty($focus->table_name))
			{
		    	$defaultTable = $focus->table_name;
			}
		}
		
		return $defaultTable;
	}
}
?>