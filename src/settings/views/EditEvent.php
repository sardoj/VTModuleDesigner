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

class Settings_ModuleDesigner_EditEvent_View extends Settings_Vtiger_Index_View
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
		
		if((!$request->get("eventobj") && !$request->get("event")) || !$request->get("languages"))
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
					
			if($request->get("eventobj"))
			{
				$a_event =  $request->get("eventobj");
			
				//Repair bug with utf8 characters
				if(!is_array($a_event))
				{
					$oldValue = Zend_Json::$useBuiltinEncoderDecoder;
					Zend_Json::$useBuiltinEncoderDecoder = true;
					$a_event = Zend_Json::decode($a_event);
					Zend_Json::$useBuiltinEncoderDecoder = $oldValue;
					
					foreach($a_event as &$val)
					{
						$val = utf8_encode($val);
					}
				}
			}

			if(empty($a_event))
			{
				$a_event["eventName"]		= trim($request->get("event"));
				$a_event["handlerPath"]		= '';
				$a_event["handlerClass"]	= '';
				$a_event["cond"]			= '';
				$a_event["dependentOn"]		= '';
				$a_event["isActive"]		= false;
			}
			
			$viewer->assign('MODULE', $moduleName);
			$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
			$viewer->assign('a_event', $a_event);
			$viewer->assign('a_languages', $a_languages);
			
			echo $viewer->view('EditEventPopup.tpl', $qualifiedModuleName,true);
		}
	}
}
?>
