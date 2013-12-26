<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="libraries/jquery/jquery.min.js"></script>
<script type="text/javascript" src="layouts/vlayout/modules/Settings/{$MODULE}/resources/jqueryForm.js"></script>

<style>
form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }
#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>
</head>

<body>
<div style="font-family: Arial,Verdana,'Times New Roman',sans-serif;">
<h2>{vtranslate('LBL_UPLOAD_MODULE', $QUALIFIED_MODULE)}</h2>

 
<form id="myForm" action="index.php?module={$MODULE}&action=UploadFile&parent=Settings" method="post" enctype="multipart/form-data">
     <input type="file" size="60" name="myfile">
     <input type="submit" value="{vtranslate('LBL_UPLOAD', $QUALIFIED_MODULE)}">
 </form>
 
 <div id="progress">
        <div id="bar"></div>
        <div id="percent">0%</div >
</div>
<br/>
 
<div id="message"></div>
 

</div>

{literal}
<script>
$(document).ready(function()
{
 
    var options = { 
    beforeSend: function() 
    {
        $("#progress").show();
        //clear everything
        $("#bar").width('0%');
        $("#message").html("");
        $("#percent").html("0%");
    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
        $("#bar").width(percentComplete+'%');
        $("#percent").html(percentComplete+'%');
 
    },
    success: function() 
    {
        $("#bar").width('100%');
        $("#percent").html('100%');
 
    },
    complete: function(response) 
    {
    	data = $.parseJSON(response.responseText);
    	
    	if(data.success)
    	{
    		//window.parent.md_selectDirectoryTemplate(undefined, data.result.module.name, data.result.basedir);
			window.parent.md_loadModule(data.result.file, true)
			window.parent.md_closePopup();
    	}
       
    },
    error: function()
    {
        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
    }
 
}; 
 
     $("#myForm").ajaxForm(options);
 
});
 
</script>
{/literal}
</body>
</html>