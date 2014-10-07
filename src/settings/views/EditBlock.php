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

class Settings_ModuleDesigner_EditBlock_View extends Settings_Vtiger_Index_View
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
		
		if((!$request->get("label") && !$request->get("block")) || !$request->get("languages"))
		{	
			//Make JSON response		
	        $response = new Vtiger_Response();	
	        $response->setError('error-param', getTranslatedString("LBL_ERROR_PARAM", $moduleName));
	        $response->emit();
			exit();
		}
				
		$languages = trim($request->get("languages"));
		$a_languages = explode(",", $languages);
				
		$a_block =  $request->get("block");
		
		//Repair bug with utf8 characters
		if(!is_array($a_block))
		{
			$oldValue = Zend_Json::$useBuiltinEncoderDecoder;
			Zend_Json::$useBuiltinEncoderDecoder = true;
			$a_block = Zend_Json::decode($a_block);
			Zend_Json::$useBuiltinEncoderDecoder = $oldValue;
			
			foreach($a_block as &$val)
			{
				$val = utf8_encode($val);
			}
		}
		
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('LIST_PARENT_TABS', $a_parent_tabs);
		$viewer->assign('LIST_MODULES', $a_modules);
		$viewer->assign('LIST_MANIFEST_TEMPLATES', $a_manifest_templates);
		$viewer->assign('LIST_DIR_TEMPLATES', $a_dir_templates);
		$viewer->assign('a_block', $a_block);
		$viewer->assign('a_languages', $a_languages);
		
		echo $viewer->view('EditBlockPopup.tpl', $qualifiedModuleName,true);
	}
}

?>