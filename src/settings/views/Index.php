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

define("DIR_TEMP", "cache/tempModuleDesigner");
 
class Settings_ModuleDesigner_Index_View extends Settings_Vtiger_Index_View {

	public function process(Vtiger_Request $request)
	{
		global $default_language;
		
		$viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);

		if (!file_exists(DIR_TEMP)) {
		    mkdir(DIR_TEMP);
		}
		
		if(!is_dir(DIR_TEMP) || !is_writable(DIR_TEMP))
		{
			die(getTranslatedString("LBL_TEMP_DIRECTORY_NOT_WRITABLE", $moduleName));
		}
		
		//Clear the temp directory
		$this->clearTempDirectory(DIR_TEMP);
		
		$db = PearDatabase::getInstance();		
		
		//Get parent tabs
		$query = "SELECT * FROM vtiger_parenttab ORDER BY parenttab_label ASC";
		$result = $db->pquery($query, array());
		
		$a_parent_tabs = array();
		while($row = $db->fetchByAssoc($result))
		{
	        switch($row['parenttab_label'])
	        {
	            case 'Sales': case 'Marketing':
	                $row['parenttab_label_string'] = 'MARKETING_AND_SALES';
	            break;
	            case 'My Home Page':
	                $row['parenttab_label_string'] = 'MY_HOME_PAGE';
	            break;
	            case 'Settings':
	                $row['parenttab_label_string'] = 'SETTINGS_TITLE';
	            break;
	            default:
	                $row['parenttab_label_string'] = strtoupper($row['parenttab_label']);
	            break;
	        }

	        $a_parent_tabs[] = $row;
		}
		
		//Get modules
		$query = "SELECT * FROM vtiger_tab ORDER BY tablabel ASC";
		$result = $db->pquery($query, array());
		
		$a_modules = array();
		while($row = $db->fetchByAssoc($result))
		{
			$a_modules[] = $row;
		}
		
		//Get templates
		$dirname = "modules/{$moduleName}/templates/";
		$dir = opendir($dirname);
		
		$a_manifest_templates = array();
		$a_dir_templates = array();
		while($file = readdir($dir))
		{
			if($file != '.' && $file != '..')
			{
				if(is_dir($dirname.$file))
				{
					$a_dir_templates[] = $file;
				}
				else
				{
					$a_manifest_templates[] = $file;
				}
			}
		}
		closedir($dir);
		
		include("languages/fr_fr/Settings/ModuleDesigner.php"); //TODO: TRANSFORM into dynamic
		$a_translations = array_merge($languageStrings, $jsLanguageStrings);
		
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('LIST_PARENT_TABS', $a_parent_tabs);
		$viewer->assign('LIST_MODULES', $a_modules);
		$viewer->assign('LIST_MANIFEST_TEMPLATES', $a_manifest_templates);
		$viewer->assign('LIST_DIR_TEMPLATES', $a_dir_templates);
		$viewer->assign('DEFAULT_LANGUAGE', $default_language);
		$viewer->assign('TRANSLATIONS', addslashes(json_encode($a_translations)));
		$viewer->assign('LAYOUT', Vtiger_Viewer::getLayoutName());
		
		echo $viewer->view('Index.tpl', $qualifiedModuleName,true);
	}
	
	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);

		$moduleName = $request->getModule();

		$jsFileNames = array(			
				"~/layouts/vlayout/modules/$moduleName/resources/bower_components/angular/angular.min.js",
				"~/layouts/vlayout/modules/$moduleName/resources/bower_components/angular-animate/angular-animate.min.js",
				"~/layouts/vlayout/modules/$moduleName/resources/bower_components/angular-aria/angular-aria.min.js",
				"~/layouts/vlayout/modules/$moduleName/resources/bower_components/angular-messages/angular-message.min.js",
				"~/layouts/vlayout/modules/$moduleName/resources/bower_components/angular-material/angular-material.min.js",
				"~/layouts/vlayout/modules/$moduleName/resources/bower_components/angular-route/angular-route.min.js",
				"modules.Settings.$moduleName.resources.Controllers",
				"modules.Settings.$moduleName.resources.App"
		);
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
	
	public function getHeaderCss(Vtiger_Request $request) {
		$headerCssInstances = parent::getHeaderCss($request);

		$moduleName = $request->getModule();

		$cssFileNames = array(
			"~/layouts/vlayout/modules/Settings/$moduleName/assets/css/ModuleDesigner.css",
			"~/layouts/vlayout/modules/$moduleName/resources/bower_components/angular-material/angular-material.min.css",
			"https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"
		);
		$cssInstances = $this->checkAndConvertCssStyles($cssFileNames);
		$headerCssInstances = array_merge($headerCssInstances, $cssInstances);

		return $headerCssInstances;
	}
	
	protected function clearTempDirectory($dir)
	{
		$files = array_diff(scandir($dir), array('.','..')); 
	    foreach ($files as $file)
	    { 
	      (is_dir("$dir/$file")) ? $this->clearTempDirectory("$dir/$file") : unlink("$dir/$file"); 
	    } 
	    return $dir != DIR_TEMP ? rmdir($dir) : false; 
	}

	function getPageTitle(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		return vtranslate('LBL_MODULEDESIGNER',$qualifiedModuleName);
	}

}