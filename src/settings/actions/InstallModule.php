<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): Jonathan SARDO.
 * Portions created by Jonathan SARDO are Copyright (C).
 *************************************************************************************/

class Settings_ModuleDesigner_InstallModule_Action extends Settings_Vtiger_Index_Action
{
	public function process(Vtiger_Request $request)
	{
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
			
		$error_code = '';
	 	$error_message = '';
		$success_message = '';
		$success = true;
		
        if(!$request->get("name") && !$request->get("version") && !$request->get("zip"))
		{
			$error_code = 'error-param';
			$error_message = getTranslatedString("LBL_ERROR_PARAM", $qualifiedModuleName);
			$success = false;
		}
		else
		{
			
			require_once("vtlib/Vtiger/Module.php");
			
			$module = Vtiger_Module::getInstance($request->get("name"));
			
			if(empty($module))
			{
				require_once("vtlib/Vtiger/PackageImport.php");
				
				$packageImport = new Vtiger_PackageImport();
				$packageImport->import($request->get("zip"));
				
				$module = Vtiger_Module::getInstance($request->get("name"));
				
				if(!empty($module))
				{
					$success_message = getTranslatedString("LBL_INSTALL_SUCCESS", $qualifiedModuleName);
				}
				else
				{
					$error_code = 'error-install';
					$error_message = getTranslatedString("LBL_INSTALL_ERROR", $qualifiedModuleName);
					$success = false;
				}
			}
			else
			{
				if($request->get("version") != $module->version)
				{	
					require_once("vtlib/Vtiger/PackageUpdate.php");
				
					$packageUpdate = new Vtiger_PackageUpdate();
					$packageUpdate->update($module, $request->get("zip"));
					
					$success_message = getTranslatedString("LBL_UPDATE_SUCCESS", $qualifiedModuleName);
				}
				else
				{
					$error_code = 'error-version';
					$error_message = getTranslatedString("LBL_UPDATE_ERROR_VERSION", $qualifiedModuleName);
					$success = false;
				}
			}
			
			//Make JSON response		
	        $response = new Vtiger_Response();
			if(!$success)
			{
	        	$response->setError($error_code, $error_message);
			}
			else
	        {
	        	$response->setResult(array('message' => $success_message));
			}
	        $response->emit();
		}
	}
}
?>
