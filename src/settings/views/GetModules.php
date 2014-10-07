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

class Settings_ModuleDesigner_GetModules_View extends Settings_Vtiger_Index_View {

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
		
		$db = PearDatabase::getInstance();
				
		$a_modules = array();
		
		$query = "SELECT * FROM vtiger_tab WHERE presence = 0 ORDER BY tablabel ASC";
		$result = $db->pquery($query, array());
		while($row = $db->fetchByAssoc($result))
		{
			$a_modules[] = $row;
		}
		
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);		
		$viewer->assign('LIST_MODULES', $a_modules);
		
		echo $viewer->view('GetModulesPopup.tpl', $qualifiedModuleName,true);		
	}
}