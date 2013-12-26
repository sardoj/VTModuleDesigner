<?php
/***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): Jonathan SARDO.
 * Portions created by Jonathan SARDO are Copyright (C).
 ************************************************************************************/

class Settings_ModuleDesigner_GetLanguages_Action extends Settings_Vtiger_Index_Action
{
	 public function process(Vtiger_Request $request)
	 {
	 	$error_code = '';
	 	$error_message = '';
		$success = true;
		$a_languages = array();
		
        if(!$request->get("dirname") && !$request->get("findlangdir") && !$request->get('mod'))
		{
			$error_code = 'error-param';
			$error_message = getTranslatedString("LBL_ERROR_PARAM", $moduleName);
			$success = false;
		}
		
		$dirname = $request->get("dirname");
		$module = $request->get('mod') != '' ? $request->get('mod') : 'ModuleName';		
		
		$old_vt_version = false;
				
		if($request->get("findlangdir"))
		{
			//Vtiger 6 package
			if(is_dir($dirname."languages"))
			{
				$dirname .= "languages/";
			}
			//Vtiger 5 package
			elseif(is_dir($dirname."modules/".$module."/language"))
			{
				$dirname .= "modules/".$module."/language/";
				$old_vt_version = true;
			}
			//Vtiger 6 default language directory
			else
			{
				$dirname = "languages/";
			}
		}
			
		if(is_dir($dirname))
		{
			//Vtiger 5
			if($old_vt_version)
			{
				$languages_dir = opendir($dirname);
				while($file = readdir($languages_dir))
				{
					if($file != '.' && $file != '..')
					{
						if(preg_match('`([a-z]+_[a-z]+)\.lang\.php`', $file, $matches))
						{
							$a_languages[] = $matches[1];
						}
					}
				}
			}
			//Vtiger 6
			else
			{
				//TODO: look in language/xx_yy/Settings directory
				
				//Open languages/ directory
				$languages_dir = opendir($dirname);				
				while($locale_file = readdir($languages_dir))
				{				
					if($locale_file != '.' && $locale_file != '..' && $locale_file != 'Settings' && is_dir($dirname.$locale_file))
					{
						//Open xx_yy locale directory
						$locale_dir = opendir($dirname.$locale_file);												
						while($file = readdir($locale_dir))
						{
							if($file != '.' && $file != '..')
							{
								//If a translation file exists for the module, add the language to the list
								if($file == $module.'.php')
								{
									$a_languages[] = $locale_file;
								}
							}
						}
						
						closedir($locale_dir);						
					}
				}
			
				closedir($languages_dir);
			}
			
			
			if(empty($a_languages))
			{
				$error_code = 'error-dirname';
				$error_message = 'Bad module dirname : '.$dirname.' - Module : '.$module;
				$success = false;
			}
		}
		else
		{
			$error_code = 'error-dirname';
			$error_message = 'Bad template dirname : '.$dirname;
			$success = false;
		}		
		
		//Make JSON response		
        $response = new Vtiger_Response();
		if(!$success)
		{
        	$response->setError($error_code, $error_message);
		}
		else
        {
        	$response->setResult(array('languages'	=> $a_languages));
		}
        $response->emit();
    }
}
