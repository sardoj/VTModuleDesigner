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
 
class Settings_ModuleDesigner_UploadFile_Action extends Settings_Vtiger_Index_Action
{
	 public function process(Vtiger_Request $request)
	 {
	 	$error_code = '';
	 	$error_message = '';
		$success = true;
		$uploaded_file = null;
 
		if(isset($_FILES["myfile"]))
		{
		    //Filter the file types , if you want.
		    if ($_FILES["myfile"]["error"] > 0)
		    {
		    	$success = false;
				$error_code = "upload-error";
				$error_message = $_FILES["file"]["error"];
		    }
		    else
		    {
		        //move the uploaded file to uploads folder;
		        move_uploaded_file($_FILES["myfile"]["tmp_name"], DIR_TEMP.$_FILES["myfile"]["name"]);
		 
		     	$uploaded_file = DIR_TEMP.$_FILES["myfile"]["name"];
		    }
		}
		else
		{
			$success = false;
			$error_code = "file-empty";
			$error_message = getTranslatedString("LBL_UPLOADED_FILE_NOT_DEFINED");
		}
		
		
		//Make JSON response		
        $response = new Vtiger_Response();
		if(!$success)
		{
        	$response->setError($error_code, $error_message);
		}
		else
        {
        	$response->setResult(array('file'	=> $uploaded_file));
		}
        $response->emit();
    }
}
