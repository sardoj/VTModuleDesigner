var MD_MODULE_NAME = 'ModuleDesigner';
var MD_QUALIFIED_MODULE_NAME = 'Settings:ModuleDesigner';

var modGeneratorUIType =
	[
		{num:1, 	label:'Text input',					dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:2, 	label:'Text input Mandatory',		dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:true,		two_columns:false},
		{num:3,		label:'Auto increment',				dbtype:'INT(11)',		datatype:'I',	mandatory:false,	two_columns:false},
		{num:4,		label:'Auto number',				dbtype:'VARCHAR(32)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:5, 	label:'Date',						dbtype:'DATE',			datatype:'D',	mandatory:false,	two_columns:false},
		{num:6, 	label:'Date time',					dbtype:'TIMESTAMP NULL',datatype:'DT',	mandatory:false,	two_columns:false},
		{num:7,		label:'Numeric input',				dbtype:'INT(11)',		datatype:'I',	mandatory:false,	two_columns:false},
		{num:8,		label:'Json array',					dbtype:'VARCHAR(512)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:9,		label:'Percentage input',			dbtype:'DECIMAL(7,3)',	datatype:'N',	mandatory:false,	two_columns:false},
		{num:10,	label:'Related module',				dbtype:'INT(19)',		datatype:'V',	mandatory:false,	two_columns:false},
		{num:11,	label:'Text input not verified',	dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:12,	label:'Email system',				dbtype:'VARCHAR(128)',	datatype:'E',	mandatory:false,	two_columns:false},
		{num:13,	label:'Email input',				dbtype:'VARCHAR(128)',	datatype:'E',	mandatory:false,	two_columns:false},
		{num:15,	label:'Pick list securised',		dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:16,	label:'Pick list',					dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:17,	label:'URL',						dbtype:'VARCHAR(256)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:19, 	label:'Text area',					dbtype:'TEXT',			datatype:'V',	mandatory:false,	two_columns:true},
		{num:20, 	label:'Text area mandatory',		dbtype:'TEXT',			datatype:'V',	mandatory:true,		two_columns:true},
		{num:21, 	label:'Text area small',			dbtype:'VARCHAR(512)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:22, 	label:'Title',						dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:23, 	label:'Date end',					dbtype:'DATE',			datatype:'D',	mandatory:false,	two_columns:false},
		{num:24, 	label:'Address',					dbtype:'VARCHAR(255)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:25, 	label:'Email Status Tracking',		dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:26, 	label:'Documents folder',			dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:27, 	label:'File type information',		dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:28, 	label:'Filename holder',			dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:30, 	label:'Reminder time',				dbtype:'TIMESTAMP NULL',datatype:'DT',	mandatory:false,	two_columns:false},
		{num:33, 	label:'Pick list multiple',			dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:51, 	label:'Account',					dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:52, 	label:'Dropdown combo input',		dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:53, 	label:'Dropdown combo radiobutton',	dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:55, 	label:'Salutation and Firstname',	dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:56, 	label:'Boolean',					dbtype:'VARCHAR(5)',	datatype:'C',	mandatory:false,	two_columns:false},
		{num:57, 	label:'Contact',					dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:69, 	label:'Image',						dbtype:'VARCHAR(256)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:70, 	label:'Date Time',					dbtype:'DATETIME',		datatype:'D',	mandatory:false,	two_columns:false},
		{num:71, 	label:'Currency',					dbtype:'DECIMAL(25,3)',	datatype:'N',	mandatory:false,	two_columns:false},
		{num:72, 	label:'Amount',						dbtype:'DECIMAL(25,8)',	datatype:'N',	mandatory:false,	two_columns:false},
		{num:73, 	label:'Account',					dbtype:'INT(11)',		datatype:'V',	mandatory:false,	two_columns:false},
		{num:76, 	label:'Potential',					dbtype:'INT(11)',		datatype:'V',	mandatory:false,	two_columns:false},
		{num:77, 	label:'User',						dbtype:'INT(11)',		datatype:'V',	mandatory:false,	two_columns:false},
		{num:83, 	label:'Tax',						dbtype:'DECIMAL(7,3)',	datatype:'N',	mandatory:false,	two_columns:false},
		{num:117, 	label:'Currency name',				dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false},
		{num:255, 	label:'Salutation auto',			dbtype:'VARCHAR(128)',	datatype:'V',	mandatory:false,	two_columns:false}
	];

var blockEdited;
var blockEditedId;
var fieldEdited;
var listSelected;
var a_blocks = [];
var a_fields = [];
var a_customLinks = [];
var a_relatedLists = [];
var a_events = [];
var a_filters = [];
var stopPopup = false;
var filter_fields_ul_droppable = true;

var defaultLanguage;
var scrollingFieldsToolbar;
var scrollingCustomLinksToolbar;
var scrollingRelatedListsToolbar;
var scrollingEventsToolbar;
var scrollingFiltersToolbar;
var jmd_container;

var md_defaultTable;

var md_entityIdentifier;

$.fn.fancybox = jQuery.fn.fancybox;

$(document).ready
(
	function()
	{
		defaultLanguage = $('#md-default-language').val();
		scrollingFieldsToolbar = $('#md-fields-toolbar');
		scrollingCustomLinksToolbar = $('#md-custom-links-toolbar');
		scrollingRelatedListsToolbar = $('#md-related-list-toolbar');
		scrollingEventsToolbar = $('#md-events-toolbar');
		scrollingFiltersToolbar = $('#md-filters-toolbar');
		scrollingTrash = $('#md-trash');
		jmd_container = $('#md-container');

		$(window).scroll
		(
			function()
			{
				scrollingFieldsToolbar.stop().animate({"marginTop": ($(window).scrollTop() + 0) + "px"}, "medium" );
				scrollingCustomLinksToolbar.stop().animate({"marginTop": ($(window).scrollTop()) + "px"}, "medium" );
				scrollingRelatedListsToolbar.stop().animate({"marginTop": ($(window).scrollTop()) + "px"}, "medium" );
				scrollingEventsToolbar.stop().animate({"marginTop": ($(window).scrollTop()) + "px"}, "medium" );
				scrollingFiltersToolbar.stop().animate({"marginTop": ($(window).scrollTop()) + "px"}, "medium" );
				scrollingTrash.stop().animate({"top": ($(window).scrollTop() + 120) + "px"}, "medium" );
			}
		);
		
		//Put a default theme to all buttons
		$("button").button();
		
		//Display or hide elements regards to the manifest
		jmd_container.find("select[name='module_manifest_template']").change(function(){
			var manifest = jmd_container.find("select[name='module_manifest_template']").val();
			
			if(manifest == 'extension.xml.php')
			{
				$("#md-tab-blocks-fields").hide();
				$("#md-tab-related-lists").hide();
				$("#md-tab-filters").hide();
			}
			else
			{
				$("#md-tab-blocks-fields").show();
				$("#md-tab-related-lists").show();
				$("#md-tab-filters").show();
			}
		});

		//Add an event on tabs
		jmd_container.find('.md-tab').click
		(
			function(event)
			{
				if($(event.target).attr("id") != "md-tab-general" && jmd_container.find("select[name='module_directory_template']").val() == '')
				{
					alert(app.vtranslate('LBL_SELECT_TEMPLATE', MD_QUALIFIED_MODULE_NAME));
				}
				else if($(event.target).attr("id") != "md-tab-general" && jmd_container.find("select[name='module_manifest_template']").val() == '')
				{
					alert(app.vtranslate('LBL_SELECT_MANIFEST', MD_QUALIFIED_MODULE_NAME));
				}
				else if($(event.target).attr("id") != "md-tab-general" && jmd_container.find("input[name='module_name']").val() == '')
				{
					alert(app.vtranslate('LBL_DEFINE_MODULE_NAME', MD_QUALIFIED_MODULE_NAME));
				}
				else
				{
					//Set default class on all tabs
					jmd_container.find(".md-tab").attr("class", "md-tab");

					//Set selected class on the clicks tab
					$(this).attr("class", "md-tab md-tab-selected");

					//Hide all pages
					jmd_container.find(".md-page").hide();

					//Show related page
					var tab_id = $(this).attr("id").replace("md-tab-", "");
					$("#md-page-"+tab_id).show();
				}
			}
		);

		//Click on the first tab
		$("#md-tab-general").click();


		//Generate UITypes list
		var UITypesOptions = '';
		$.each
		(
			modGeneratorUIType,
			function()
			{
				UITypesOptions += '<li>'+this.num+' - '+this.label+'</li>';
			}
		);


		//Add UITypes
		$("#md-fields-list li").remove();
		$("#md-fields-list").append(UITypesOptions);
		
		
		$("select[name='module_parent_tab']").change(
			function()
			{
				if($(this).val() == 'CUSTOM')
				{
					$("input[name='module_parent_tab_name']").val('');
					$("tr#module_parent_tab_custom").show();
				}
				else
				{
					$("tr#module_parent_tab_custom").hide();
				}
			}
		);


		//Make UITypes draggable
		$("#md-fields-list li").draggable
		(
			{
				opacity: 0.7,
				helper: 'clone',
				start: function( event, ui )
				{
					stopPopup = false;
				}
			}
		);

		//Make Blocks sortable
		$("#md-blocks-ul").sortable
		(
			{
				start: function( event, ui )
				{					
					jmd_container.find(".md-fields-ul").droppable("disable");

					$(this).css("opacity", "0.75");

					md_showTrash();
				},
				stop: function( event, ui )
				{

					jmd_container.find(".md-fields-ul").droppable("enable");

					$(this).css("opacity", "1");

					md_hideTrash();
				}
			}
		);
		$("#md-blocks-ul").sortable("disable");

		////////////////////////////////////////

		var custom_links_ul_droppable = true;

		//Make Custom Links draggable
		$("#md-custom-links-list li").draggable
		(
			{
				opacity: 0.7,
				helper: 'clone'
			}
		);

		//Make Custom Links ul droppable
		jmd_container.find(".md-custom-links-ul")
			.droppable({
				hoverClass: "md-custom-links-ul-hover",
				drop: function( event, ui ) {
					if(custom_links_ul_droppable)
					{
						md_openPopup("index.php?module="+MD_MODULE_NAME+"&view=EditCustomLink&type="+$(ui.draggable).text());

						listSelected = this;
					}
				}
			})
			.sortable({
				start: function( event, ui) {
					custom_links_ul_droppable = false;

					md_showTrash();
				},
				stop: function( event, ui) {
					custom_links_ul_droppable = true;

					md_hideTrash();
				}
			});

		////////////////////////////////////////

		var related_lists_ul_droppable = true;

		//Make modules draggable
		$("#md-modules-list li").draggable
		(
			{
				opacity: 0.7,
				helper: 'clone'
			}
		);

		//Make Related List ul droppable
		jmd_container.find(".md-related-lists-ul")
			.droppable({
				hoverClass: "md-related-lists-ul-hover",
				drop: function( event, ui ) {
					if(related_lists_ul_droppable)
					{
						md_openPopup("index.php?module="+MD_MODULE_NAME+"&view=EditRelatedList&relmodule="+$(ui.draggable).text());

						listSelected = this;
					}
				}
			})
			.sortable({
				start: function( event, ui) {
					related_lists_ul_droppable = false;

					md_showTrash();
				},
				stop: function( event, ui) {
					related_lists_ul_droppable = true;

					md_hideTrash();
				}
			});
			
		jmd_container.find("#md_related_list_other_module").button().click
		(
			function()
			{
        		$("#md_related_list_dialog_form").dialog("open");
     		 }
     	);
     	
     	jmd_container.find("#md_related_list_dialog_form").dialog({
		      autoOpen: false,
		      height: 180,
		      width: 250,
		      modal: true,
		      buttons: {
		        "Ajouter": function()
		        {
		        	if($("#md_related_list_custom_name").val() != '')
		        	{		          
		          		md_openPopup("index.php?module="+MD_MODULE_NAME+"&view=EditRelatedList&relmodule="+$("#md_related_list_custom_name").val());
		          		
		          		$(this).dialog("close");
		          	}					
		        },
		        Cancel: function() {
		          $(this).dialog("close");
		        }
		      },
		      close: function() {
		        $("#md_related_list_custom_name").val('');
		      }
		    });

		////////////////////////////////////////

		var events_ul_droppable = true;

		//Make events draggable
		$("#md-events-list li").draggable
		(
			{
				opacity: 0.7,
				helper: 'clone'
			}
		);

		//Make events ul droppable
		jmd_container.find(".md-events-ul")
			.droppable({
				hoverClass: "md-events-ul-hover",
				drop: function( event, ui ) {
					if(events_ul_droppable) {
						md_openPopup("index.php?module="+MD_MODULE_NAME+"&view=EditEvent&event="+$(ui.draggable).text());

						listSelected = this;
					}
				}
			})
			.sortable({
				start: function( event, ui) {
					events_ul_droppable = false;

					md_showTrash();
				},
				stop: function( event, ui) {
					events_ul_droppable = true;

					md_hideTrash();
				}
			});
			
		//Make Filter Blocks sortable
		$("#md-filters-ul")
			.sortable({
				start: function( event, ui ) {
					jmd_container.find(".md-filter-fields-ul").droppable("disable");

					$(this).css("opacity", "0.75");

					md_showTrash();
				},
				stop: function( event, ui ) {
					jmd_container.find(".md-filter-fields-ul").droppable("enable");

					$(this).css("opacity", "1");

					md_hideTrash();
				},
				out: function( event, ui ) {

				}
			})
			.sortable("disable");

		////////////////////////////////
		//Make trash droppable
		jmd_container.find(".md-trash").droppable({
			hoverClass: "md-trash-hover",
			tolerance: "touch",
			drop: function( event, ui ) {
				md_dropToTrash(ui);

				md_hideTrash();
			}
		});


		//Set fancybox
		$("#md-edit-popup-link").fancybox({
			maxWidth	: 600,
			maxHeight	: 490,
			fitToView	: false,
			width		: '75%',
			height		: '75%',
			autoSize	: false,
			closeClick	: false,
			openEffect	: 'none',
			closeEffect	: 'none'
		});

		//Create the General information block
		md_addBlock();
		
		//Create the System information block
		md_addBlock();
		
		//Create filter
		md_addFilter();

		//Create mandatory fields
		md_createMandatoryFields();
	}
);

function md_createMandatoryFields()
{
	blockEdited = $("#md-block-1 ul.md-fields-ul");
	blockEditedId = 0;
	

	//Assigned To
	var o_field = new Object();
	o_field.id							= 'md-field-1-0';
	o_field.index						= 1;
	o_field.UITypeNum					= 53;
	o_field.UITypeName					= 'Dropdown combo radiobutton';
	o_field.UITypeDBType				= 'INT(19)';
	o_field.UITypeDataType				= 'V';
	o_field.twoColumns					= false;
	o_field.fieldName					= 'assigned_user_id';
	o_field.label						= 'Assigned To';
	o_field.columnName					= 'smownerid';
	o_field.tableName					= 'vtiger_crmentity';
	o_field.helpInfoLabel				= '';
	o_field.defaultValue				= '';
	o_field.generatedType				= 1;
	o_field.displayType					= 1;
	o_field.mandatory					= true;
	o_field.isEntityIdentifier			= false;
	o_field.entityIdentifierFieldName	= '';
	o_field.inFilterAll					= false;
	o_field.inPopup						= false;
	o_field.inRelatedList				= false;
	o_field.quickCreate					= true;
	o_field.massEditable				= true;
	o_field.readOnly					= false;
	o_field.relatedModule				= null;
	o_field.pickListValues				= null;
	md_addField(o_field, true);

	 //Assigned To
	var o_field = new Object();
	o_field.id							= 'md-field-1-1';
	o_field.index						= 2;
	o_field.UITypeNum					= 70;
	o_field.UITypeName					= 'Date time';
	o_field.UITypeDBType				= 'DATETIME';
	o_field.UITypeDataType				= 'T';
	o_field.twoColumns					= false;
	o_field.fieldName					= 'createdtime';
	o_field.label						= 'Created Time';
	o_field.columnName					= 'createdtime';
	o_field.tableName					= 'vtiger_crmentity';
	o_field.helpInfoLabel				= '';
	o_field.defaultValue				= '';
	o_field.generatedType				= 1;
	o_field.displayType					= 2;
	o_field.mandatory					= false;
	o_field.isEntityIdentifier			= false;
	o_field.entityIdentifierFieldName	= '';
	o_field.inFilterAll					= false;
	o_field.inPopup						= false;
	o_field.inRelatedList				= false;
	o_field.quickCreate					= true;
	o_field.massEditable				= false;
	o_field.readOnly					= false;
	o_field.relatedModule				= null;
	o_field.pickListValues				= null;
	md_addField(o_field, true);

	//Modified Time
	var o_field = new Object();
	o_field.id							= 'md-field-1-2';
	o_field.index						= 3;
	o_field.UITypeNum					= 19;
	o_field.UITypeName					= 'Date time';
	o_field.UITypeDBType				= 'DATETIME';
	o_field.UITypeDataType				= 'T';
	o_field.twoColumns					= false;
	o_field.fieldName					= 'modifiedtime';
	o_field.label						= 'Modified Time';
	o_field.columnName					= 'modifiedtime';
	o_field.tableName					= 'vtiger_crmentity';
	o_field.helpInfoLabel				= '';
	o_field.defaultValue				= '';
	o_field.generatedType				= 1;
	o_field.displayType					= 2;
	o_field.mandatory					= false;
	o_field.isEntityIdentifier			= false;
	o_field.entityIdentifierFieldName	= '';
	o_field.inFilterAll					= false;
	o_field.inPopup						= false;
	o_field.inRelatedList				= false;
	o_field.quickCreate					= true;
	o_field.massEditable				= false;
	o_field.readOnly					= false;
	o_field.relatedModule				= null;
	o_field.pickListValues				= null;
	md_addField(o_field, true);
}

function md_setModuleName(input)
{	
	var cursor_position = $(input).caret();
	
	var value = $(input).val().replace(/[^0-9a-zA-Z]/g, '');
	$(input).val($.ucfirst(value));
	
		
	$(input).caret(cursor_position);
}

function md_updateFieldsTableName(ti)
{
	var old_module_table_name = $("input[name='old_module_table_name']").val();
	var new_module_table_name = 'vtiger_'+$(ti).val().toLowerCase();
	
	if(old_module_table_name != new_module_table_name)
	{
		for(var i=0; i<a_fields.length; i++)
		{
			if(a_fields[i].tableName == old_module_table_name)
			{
				a_fields[i].tableName = new_module_table_name;
			}
		}
		
		$("input[name='old_module_table_name']").val(new_module_table_name);
	}
}

function md_dropToTrash(ui)
{
	var className = $(ui.draggable).attr("class");
	var id = $(ui.draggable).attr("id");
	var editable = $(ui.draggable).attr("md-editable");
	var error = false;

	var a_array;

	if(className.search("md-block") > -1)
	{
		a_array = a_blocks;
	}
	else if(className.search("md-field") > -1)
	{
		a_array = a_fields;
	}
	else if(className.search("md-custom-link") > -1)
	{
		a_array = a_customLinks;
	}
	else if(className.search("md-related-list") > -1)
	{
		a_array = a_relatedLists;
	}
	else if(className.search("md-event") > -1)
	{
		a_array = a_events;
	}
	else if(className.search("md-filter-field") > -1)
	{
		a_array = undefined;
	}
	else if(className.search("md-filter") > -1)
	{
		if($(ui.draggable).find("input").val() == 'All')
		{
			alert(app.vtranslate('LBL_CANNOT_DELETE_FILTER_ALL', MD_QUALIFIED_MODULE_NAME));
			return;
		}

		jmd_container.find(".md-filter-fields-ul").droppable("enable");
	}

	if(a_array != undefined)
	{
		//Delete array element
		var found = false;
		for(var i=0; i<a_array.length && !found; i++)
		{
			if(a_array[i].id == id)
			{
				//If it is a block, we have to delete block's fields
				if(className.search("md-block") > -1)
				{
					//First, we search if some field are not editable
					if(md_checkEditableFieldsInBlock(id) === false)
					{
						error = true;
						break;
					}

					md_deleteFieldsInBlock(id);

					jmd_container.find(".md-fields-ul").droppable("enable"); //We have to enable blocks droppable because it was deleted when sort started. See $("#md-blocks-ul").sortable() function
				}
				else if(className.search("md-field") > -1)
				{
					//First, we check if field is editable
					var editable = $("#"+a_array[i].id).attr("md-editable");
					if(editable !== 'true')
					{
						alert(app.vtranslate('LBL_CANNOT_EDIT_REMOVE_FIELD', MD_QUALIFIED_MODULE_NAME));
						error = true;

						break;
					}
					//Delete filter fields from toolbar
					var a_filterFieldsDraggable = $("#md-filter-fields-list").children();
					for(var j=0; j<a_filterFieldsDraggable.length; j++)
					{
						if($(a_filterFieldsDraggable[j]).text() == a_array[i].fieldName)
						{
							$(a_filterFieldsDraggable[j]).remove();
						}
					}

					//Delete filter fields from filters
					a_filterFieldsDraggable = jmd_container.find(".md-filter-fields-ul").children();
					for(var j=0; j<a_filterFieldsDraggable.length; j++)
					{
						if($(a_filterFieldsDraggable[j]).text() == a_array[i].fieldName)
						{
							$(a_filterFieldsDraggable[j]).remove();
						}
					}
				}

				a_array.splice(i, 1);

				found = true;
			}
		}
	}

	if(error === false)
	{
		//Remove html element
		jmd_container.find("#"+id).remove();
		
		/*if(jmd_container.find(".ui-sortable-placeholder").length > 0)
		{
			jmd_container.find(".ui-sortable-placeholder").remove();
		}*/

		 if(className.search("md-filter-field") > -1)
		{
			filter_fields_ul_droppable = true;
		}
	}
}

function md_deleteFieldsInBlock(block_id)
{
	var a_id = block_id.split("-");
	var index = a_id[2];

	var a_newFields = [];

	$.each
	(
		a_fields,
		function(i)
		{
			if(this.id != undefined && this.id.search("md-field-"+index+"-") == -1)
			{
				a_newFields.push(this);
			}
		}
	);

	a_fields = a_newFields;
}

function md_checkEditableFieldsInBlock(block_id)
{        
	found = true;

	$("#"+block_id+" li").each(function() {
		var editable = $(this).attr("md-editable");

		if(editable !== 'true')
		{
			alert(app.vtranslate('LBL_CANNOT_BLOCK_REMOVE_FIELD', MD_QUALIFIED_MODULE_NAME));
			found = false;
			
			return false;
		}
	});

	return found;
}

function md_openPopup(url)
{
	var languages = jmd_container.find("input[name='md-languages']").val();

	url += url.search(/\?/) > -1 ? '&' : '?';
	url += 'languages='+languages;
	url += '&parent=Settings';
	
	$("#md-edit-popup-link").attr("href", url);
	$("#md-edit-popup-link").click();
}

function md_selectDirectory(cb, moduleName, moduleDirName)
{
	var calledUrl;
	var autoSelectModuleDirectory = true;
	
	if(cb != undefined)
	{
		var template = $(cb).val();

		if(template == '')
		{
			return;
		}

		calledUrl = "index.php?module="+MD_MODULE_NAME+"&action=GetLanguages&dirname=modules/"+MD_MODULE_NAME+"/templates/"+template+"/LANGUAGES/&parent=Settings";
		
		autoSelectModuleDirectory = false;
	}
	else if(moduleDirName != undefined)
	{
		calledUrl = "index.php?module="+MD_MODULE_NAME+"&action=GetLanguages&dirname="+moduleDirName+"&mod="+moduleName+"&findlangdir=1&parent=Settings";
	}
	else if(moduleName != undefined)
	{
		calledUrl = "index.php?module="+MD_MODULE_NAME+"&action=GetLanguages&dirname=languages/&mod="+moduleName+"&parent=Settings";
	}
	
	$.ajax
	(
		{
			url: calledUrl,
			success: function(response)
			{	
				if(!response.success)
				{
					alert(response.error.message);
				}
				else
				{
					var html = '';
					var language;
					
					for(var i=0; i<response.result.languages.length; i++)
					{
						language = response.result.languages[i];
						
						html += '<tr class="md-module-name-translation">'+
								'<td>'+app.vtranslate('LBL_MODULE_NAME_TRANSLATION', MD_QUALIFIED_MODULE_NAME)+' <em>'+language+'</em></td>'+
								'<td colspan="2"><input type="text" name="module_label_'+language+'" class="md-medium-text-input" /></td>'+
								'</tr>';
						
						html += '<tr class="md-module-name-translation">'+
								'<td>'+app.vtranslate('LBL_MODULE_NAME_SINGLE_TRANSLATION', MD_QUALIFIED_MODULE_NAME)+' <em>'+language+'</em></td>'+
								'<td colspan="2"><input type="text" name="module_label_single_'+language+'" class="md-medium-text-input" /></td>'+
								'</tr>';
					}
					
					jmd_container.find(".md-module-name-translation").remove();

					$("#md-module-name:first").append(html);
					jmd_container.find("input[name='md-languages']").val(response.result.languages.join(','));
					
					setModuleData(autoSelectModuleDirectory, moduleDirName);
				}
			},
			error: function(data)
			{
				alert(app.vtranslate('LBL_ERROR_TRY_AGAIN', MD_QUALIFIED_MODULE_NAME));
			}
		}
	);
}

function md_addBlock(o_block, isImporting)
{	
	//Edit existing block
	if(isImporting == true)
	{	
		//Set block index
		o_block.index = a_blocks.length + 1;
		o_block.maxFieldId = 0;

		//Add block object
		a_blocks.push(o_block);
	}
	else //Add new block
	{
		o_block = new Object();
		o_block.index = a_blocks.length + 1;
		o_block.id = "md-block-"+a_blocks.length;	
		o_block.maxFieldId = 0;
		
		switch(a_blocks.length)
		{
			case 0:  o_block.label = 'LBL_BLOCK_GENERAL_INFORMATION';
				break;
			case 1:  o_block.label = 'LBL_BLOCK_SYSTEM_INFORMATION';
				break;
			default: o_block.label = 'LBL_BLOCK_'+a_blocks.length;
				break;
		}		

		//Add block object
		a_blocks.push(o_block);
	}

	row = '<li id="'+o_block.id+'" class="md-block">';
	row += '<div class="md-block-anchor"><div class="md-anchor-out"></div><div class="md-anchor-out"></div><div class="md-anchor-out"></div></div>';
	row += '<input type="text" name="'+o_block.id+'-label" value="'+o_block.label+'" class="md_block_name" /> ';
	row += '<a href="javascript:md_openBlockPopup(\''+o_block.id+'\')">Details</a><br />';
	//row += '<input id="seq-'+o_block.id+'" type="text" value="'+o_block.index+'" size="2" />';
	row += '<ul class="md-fields-ul" block_id="'+o_block.id+'"></ul>';
	row += '</li>';

	$("#md-blocks-ul").append(row);

	jmd_container.find('div.md-block-anchor')
		.hover(function() {
				$(this).find("div").attr('class', 'md-anchor-over');
			}, function() {
				$(this).find("div").attr('class', 'md-anchor-out');
		})
		.mousedown(function() {
			$("#md-blocks-ul").sortable("enable");
		})
		.mouseup(function() {
			$("#md-blocks-ul").sortable("disable");
		})
		.hover()
	;

	var jfields_ul = jmd_container.find(".md-fields-ul");
	//Make fields-ul droppable
	jfields_ul.droppable({
		hoverClass: "md-block-fields-hover",
		connectWith: "#md-container .md-fields",
		drop: function( event, ui )
		{
			var a_uitypeData = $(ui.draggable).text().split('-');
			var uitype_num = a_uitypeData[0].replace(' ', '');
			var uitype_name = a_uitypeData[1].replace(' ', '');

			blockEdited = this;

			//Get block id
			//blockEditedId = $(event.target).parents().find(".md-block:first").attr("id").replace("md-block-", "");
			blockEditedId = $(this).attr("block_id").replace("md-block-", "");

			if(!stopPopup)
			{
				var editedModuleName = jmd_container.find("input[name='module_name']").val();

				var existantModule = jmd_container.find("select[name='module_directory_template']").val() == 'EXISTANT' ? '1' : '0';
			
				md_openPopup("index.php?module="+MD_MODULE_NAME+"&view=EditField&mod="+editedModuleName+"&exist="+existantModule+"&uitype="+uitype_num);
			}
		}
	});

	//Reactivate popup when sort ending
	jfields_ul.sortable
	(
		{
			connectWith: "ul",
			hoverClass: "md-block-fields-sort",
			start: function( event, ui )
			{
				stopPopup = true;

				md_showTrash();
			},
			stop: function ( event, ui )
			{
				md_hideTrash();

				//Set field sequence in destination block				
				var html_block_id = $(fieldEdited).parents(".md-block:first").attr("id");

				if(html_block_id != undefined)
				{
					//Update field id to link it to the destination block
					md_updateFieldId(fieldEdited, html_block_id);
				}
			}
		}
	);

	jfields_ul.disableSelection();
}

function md_openBlockPopup(block_id)
{
	for(var i=0; i<a_blocks.length; i++)
	{
		var o_block = a_blocks[i];

		if(o_block.id == block_id)
		{
			o_block.label = jmd_container.find("input[name='"+o_block.id+"-label']").val();
			md_openPopup('index.php?module='+MD_MODULE_NAME+'&view=EditBlock&block='+escape(JSON.stringify(o_block)));
		}
	}
}

function md_editBlock(o_block)
{
	for(var i=0; i<a_blocks.length; i++)
	{
		if(a_blocks[i].id == o_block.id)
		{			
			a_blocks[i] = o_block;

			jmd_container.find("input[name='"+o_block.id+"-label']").val(o_block.label);
		}
	}
}

function md_updateFieldId(field, block_id)
{
	updateBlockMaxFieldId(block_id);

	var oldFieldId = $(field).attr("id");
	
	var a_blockId = block_id.split("-");
	var maxBlockFieldId = getBlockMaxFieldId(block_id);

	field.id = "md-field-"+a_blockId[2]+"-"+maxBlockFieldId;

	$(field).attr("id", field.id);

	//Set the new field id
	md_setFieldNewId(oldFieldId, field.id);
}

function md_setFieldNewId(old_field_id, new_field_id)
{
	for(var i=0; i<a_fields.length; i++)
	{
		if(a_fields[i].id == old_field_id)
		{
			a_fields[i].id = new_field_id;
		}
	}
}

function md_addField(o_field, isImporting)
{
	jblock_edited = $(blockEdited);
	
	//Edit existing field
	if(o_field.id != undefined && isImporting != true)
	{
		for(var i=0; i<a_fields.length; i++)
		{
			if(a_fields[i].id == o_field.id)
			{
				a_fields[i] = o_field;
				$("#"+o_field.id).remove();


				//Delete filter fields from filters
				var a_filterFieldsDraggable = jmd_container.find(".md-filter-fields-ul").children();
				for(var j=0; j<a_filterFieldsDraggable.length; j++)
				{
					if($(a_filterFieldsDraggable[j]).text() == o_field.oldFieldName)
					{
						$(a_filterFieldsDraggable[j]).remove();
					}
				}

				a_filterFieldsDraggable = $("#md-filter-fields-list").children();
				for(var j=0; j<a_filterFieldsDraggable.length; j++)
				{
					if($(a_filterFieldsDraggable[j]).text() == o_field.oldFieldName)
					{
						$(a_filterFieldsDraggable[j]).remove();
					}
				}
			}
		}
	}
	else if(isImporting == true)
	{
		//Set field index
		o_field.index = jblock_edited.find("li").length + 1;
	
		//Save identifier
		if(o_field.isEntityIdentifier)
		{
			md_entityIdentifier = o_field.fieldName;
		}

		//Add field object
		a_fields.push(o_field);
	}
	else //Add new field
	{
		var blockMaxFieldId = getBlockMaxFieldId("md-block-"+blockEditedId);

		//Set field index
		o_field.index = blockEdited.children.length + 1;
		o_field.id = "md-field-"+blockEditedId+"-"+blockMaxFieldId;

		//Add field object
		a_fields.push(o_field);
	}

	var a_field_id_data = o_field.id.split("-");
	updateBlockMaxFieldId("md-block-"+a_field_id_data[2]);
	
	//Disallow edition of system fields
	if(o_field.fieldName == 'assigned_user_id' || o_field.fieldName == 'createdtime' || o_field.fieldName == 'modifiedtime' || o_field.fieldName == 'modifiedby')
	{
		o_field.MDEditable = false;
	}
	else
	{
		o_field.MDEditable = true;
	}

	//Add field in block graphicly
	var li_class = o_field.twoColumns ? 'md-field two_columns' : 'md-field';
	
	row = '<li id="'+o_field.id+'" class="'+li_class+'" md-editable="'+o_field.MDEditable+'">';
	row += '<div class="md-field-details">';
	row += '<span>'+o_field.fieldName+'<span><br />';
	row += '<span class="md-field-type">'+o_field.UITypeNum+' - '+o_field.UITypeName+'</span>';
	row += '</div>';
	row += '<div class="md-field-images">';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_field.mandatory ? 'mandatory' : 'mandatory-bw')+'.png" class="'+(o_field.mandatory ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_field.isEntityIdentifier ? 'entityidentifier' : 'entityidentifier-bw')+'.png" class="'+(o_field.isEntityIdentifier ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_field.inFilterAll ? 'filterall' : 'filterall-bw')+'.png" class="'+(o_field.inFilterAll ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_field.inPopup ? 'popup' : 'popup-bw')+'.png" class="'+(o_field.inPopup ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_field.inRelatedList ? 'related' : 'related-bw')+'.png" class="'+(o_field.inRelatedList ? 'md-icon-active' : 'md-icon-inactive')+'" /><br /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_field.quickCreate ? 'create' : 'create-bw')+'.png" class="'+(o_field.quickCreate ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_field.massEditable ? 'massedit' : 'massedit-bw')+'.png" class="'+(o_field.massEditable ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_field.defaultValue != '' ? 'defaultvalue' : 'defaultvalue-bw')+'.png" class="'+(o_field.defaultValue != '' ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_field.helpInfoLabel != '' ? 'helpinfo' : 'helpinfo-bw')+'.png" class="'+(o_field.helpInfoLabel != '' ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_field.readOnly ? 'readonly' : 'readonly-bw')+'.png" class="'+(o_field.readOnly != '' ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '</div>';
	row += '</li>';
	
	// //If it is needed we add the field in the filter all
	// if(o_field.inFilterAll)
	// {
		// $("#md-filter-0 ul").append('<li class="md-filter-field">'+o_field.fieldName+'</li>');
	// }

	if(isImporting == true)
	{
		jblock_edited.append(row);
	}
	else
	{
		if(o_field.index > 1)
		{
			jblock_edited.find("li:eq("+(o_field.index - 2)+")").after(row);
		}
		else if(o_field.index == 1 && jblock_edited.children.length > 0)
		{
			jblock_edited.prepend(row);
		}
		else
		{
			jblock_edited.append(row);
		}
	}

	jmd_container.find(".md-field").mousedown(function(){fieldEdited = this; stopPopup = true;});

	$("#"+o_field.id).dblclick
	(
		function()
		{
			if($(this).attr("md-editable") == 'true')
			{
				o_field = getFieldData($(this).attr("id"));
	
				var a_fieldId = o_field.id.split("-");
				var blockNum = a_fieldId[2];
	
				blockEdited = $("#md-block-"+blockNum+" ul");
	
				var editedModuleName = jmd_container.find("input[name='module_name']").val();
				
				var existantModule = jmd_container.find("select[name='module_directory_template']").val() == 'EXISTANT' ? '1' : '0';
	
				var field_json = encode_utf8(JSON.stringify(o_field));
	
				md_openPopup("index.php?module="+MD_MODULE_NAME+"&view=EditField&mod="+editedModuleName+"&exist="+existantModule+"&field="+escape(field_json));
			}
			else
			{
				alert(app.vtranslate('LBL_NOT_ALLOWED_TO_EDIT_THE_FIELD', MD_MODULE_NAME));
			}
		}
	);

	md_addFilterableField(o_field);
}

function encode_utf8(s) {
  return unescape(encodeURIComponent(s));
}

function getFieldData(field_id)
{
	for(var i=0; i<a_fields.length; i++)
	{
		if(a_fields[i].id == field_id)
		{
			return a_fields[i];
		}
	}

	return false;
}

function getBlockMaxFieldId(block_id)
{
	for(var i=0; i<a_blocks.length; i++)
	{
		if(a_blocks[i].id == block_id)
		{
			return a_blocks[i].maxFieldId;
		}
	}

	return false;
}

function updateBlockMaxFieldId(block_id)
{
	for(var i=0; i<a_blocks.length; i++)
	{
		if(a_blocks[i].id == block_id)
		{
			a_blocks[i].maxFieldId++;
		}
	}
}

function md_checkForm()
{
	var result = '';

	var o_field;
	for(var i=0; i<a_fields.length; i++)
	{
		o_field = a_fields[i];

		result += 'id: '+o_field.id+' - index: '+o_field.index+' - uitype: '+o_field.UITypeNum+' - '+o_field.UITypeName+' \n ';
	}

	return false;
}

function md_closePopup()
{
	$.fancybox.close();
}

////////////////////
/// CUSTOM LINKS ///
////////////////////

function md_addCustomLink(o_customLink, isImporting)
{
	var jlist_selected = $(listSelected);
	//Edit existing Custom Link
	if(o_customLink.id != undefined && isImporting != true)
	{
		for(var i=0; i<a_customLinks.length; i++)
		{
			if(a_customLinks[i].id == o_customLink.id)
			{
				a_customLinks[i] = o_customLink;
				$("#"+o_customLink.id).remove();
			}
		}
	}
	else if(isImporting == true)
	{
		//Set custom link index
		o_customLink.index = jlist_selected.find("li").length + 1;

		//Add custom link object
		a_customLinks.push(o_customLink);
	}
	else //Add new Custom Link
	{
		//Set custom link index
		o_customLink.index = jlist_selected.find("li").length + 1;
		o_customLink.id = "md-custom-link-"+a_customLinks.length;

		//Add custom link object
		a_customLinks.push(o_customLink);
	}

	//Add custom link graphicly
	row = '<li id="'+o_customLink.id+'" class="md-custom-link">';
	row += o_customLink.type;
	//row += ' <input id="seq-'+o_customLink.id+'" type="text" value="'+o_customLink.index+'" size="2" />';
	row += '<div class="md-custom-link-images">';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_customLink.icon != '' ? 'icon' : 'icon-bw')+'.png" class="'+(o_customLink.icon != '' ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_customLink.handlerPath != '' ? 'handler-path' : 'handler-path-bw')+'.png" class="'+(o_customLink.handlerPath != '' ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_customLink.handlerClass != '' ? 'handler-class' : 'handler-class-bw')+'.png" class="'+(o_customLink.handlerClass != '' ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_customLink.handler != '' ? 'handler' : 'handler-bw')+'.png" class="'+(o_customLink.handler != '' ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '</div>';
	row += '<span class="md-custom-link-url">'+o_customLink.url+'</span>';
	row += '</li>';

	if(isImporting != true)
	{
		if(o_customLink.index > 1)
		{
			jlist_selected.find("li:eq("+(o_customLink.index - 2)+")").after(row);
		}
		else if(o_customLink.index == 1 && $(listSelected).children.length > 0)
		{
			jlist_selected.prepend(row);
		}
		else
		{
			jlist_selected.append(row);
		}
	}
	else
	{
		jlist_selected.append(row);
	}

	$("#"+o_customLink.id).dblclick
	(
		function()
		{
			o_customLink = getCustomLinkData($(this).attr("id"));

			listSelected = $("#md-custom-links-ul");
			md_openPopup("index.php?module="+MD_MODULE_NAME+"&view=EditCustomLink&customlink="+escape(JSON.stringify(o_customLink)));
		}
	);
}

function getCustomLinkData(customLink_id)
{
	for(var i=0; i<a_customLinks.length; i++)
	{
		if(a_customLinks[i].id == customLink_id)
		{
			return a_customLinks[i];
		}
	}

	return false;
}

/////////////////////
/// RELATED LISTS ///
/////////////////////

function md_addRelatedList(o_relatedList, isImporting)
{
	var jlist_selected = $(listSelected);
	//Edit existing related list
	if(o_relatedList.id != undefined && isImporting != true)
	{
		for(var i=0; i<a_relatedLists.length; i++)
		{
			if(a_relatedLists[i].id == o_relatedList.id)
			{
				a_relatedLists[i] = o_relatedList;
				$("#"+o_relatedList.id).remove();
			}
		}
	}
	else if(isImporting == true)
	{
		//Set related list index
		o_relatedList.index = jlist_selected.find("li").length + 1;

		//Add related list object
		a_relatedLists.push(o_relatedList);
	}
	else //Add new related list
	{
		//Set related list index
		o_relatedList.index = jlist_selected.find("li").length + 1;
		o_relatedList.id = "md-related-list-"+a_relatedLists.length;

		//Add related list object
		a_relatedLists.push(o_relatedList);
	}


	//Add related list graphicly
	row = '<li id="'+o_relatedList.id+'" class="md-related-list">';
	row += o_relatedList.relatedModule;
	//row += ' <input id="seq-'+o_relatedList.id+'" type="text" value="'+o_relatedList.index+'" size="2" />';
	row += '<div class="md-related-list-images">';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_relatedList.presence == 1 ? 'presence' : 'presence-bw')+'.png" class="'+(o_relatedList.presence == 1 ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_relatedList.actionAdd ? 'add' : 'add-bw')+'.png" class="'+(o_relatedList.actionAdd ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_relatedList.actionSelect ? 'select' : 'select-bw')+'.png" class="'+(o_relatedList.actionSelect != '' ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '</div>';
	row += '<span class="md-related-list-name">'+o_relatedList.functionName+'()</span>';
	row += '</li>';

	if(isImporting != true)
	{
		if(o_relatedList.index > 1)
		{
			jlist_selected.find("li:eq("+(o_relatedList.index - 2)+")").after(row);
		}
		else if(o_relatedList.index == 1 && jlist_selected.children.length > 0)
		{
			jlist_selected.prepend(row);
		}
		else
		{
			jlist_selected.append(row);
		}
	}
	else
	{
		jlist_selected.append(row);
	}

	$("#"+o_relatedList.id).dblclick
	(
		function()
		{
			o_relatedList = getRelatedListData($(this).attr("id"));

			listSelected = $("#md-related-lists-ul");

			md_openPopup("index.php?module="+MD_MODULE_NAME+"&view=EditRelatedList&relatedlist="+escape(JSON.stringify(o_relatedList)));
		}
	);
}

function getRelatedListData(relatedList_id)
{
	for(var i=0; i<a_relatedLists.length; i++)
	{
		if(a_relatedLists[i].id == relatedList_id)
		{
			return a_relatedLists[i];
		}
	}

	return false;
}

//////////////
/// EVENTS ///
//////////////

function md_addEvent(o_event, isImporting)
{
	var jlist_selected = $(listSelected);
	//Edit existing event
	if(o_event.id != undefined && isImporting != true)
	{
		for(var i=0; i<a_events.length; i++)
		{
			if(a_events[i].id == o_event.id)
			{
				a_events[i] = o_event;
				$("#"+o_event.id).remove();
			}
		}
	}
	else if(isImporting == true)
	{
		//Set event index
		o_event.index = jlist_selected.find("li").length + 1;

		//Add event object
		a_events.push(o_event);
	}
	else //Add new event
	{
		//Set related list index
		o_event.index = jlist_selected.find("li").length + 1;
		o_event.id = "md-event-"+a_events.length;

		//Add event object
		a_events.push(o_event);
	}


	//Add related list graphicly
	row = '<li id="'+o_event.id+'" class="md-event">';
	row += o_event.eventName;
	//row += ' <input id="seq-'+o_event.id+'" type="text" value="'+o_event.index+'" size="2" />';
	row += '<div class="md-event-images">';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_event.isActive ? 'active' : 'active-bw')+'.png" class="'+(o_event.isActive ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_event.cond != '' ? 'cond' : 'cond-bw')+'.png" class="'+(o_event.cond != '' ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '<img src="layouts/vlayout/modules/Settings/'+MD_MODULE_NAME+'/assets/images/'+(o_event.dependentOn != '' ? 'dependent' : 'dependent-bw')+'.png" class="'+(o_event.dependentOn != '' ? 'md-icon-active' : 'md-icon-inactive')+'" /> ';
	row += '</div>';
	row += '<span class="md-event-handler-class">'+o_event.handlerClass+'</span>';
	row += '</li>';

	if(isImporting != true)
	{
		if(o_event.index > 1)
		{
			jlist_selected.find("li:eq("+(o_event.index - 2)+")").after(row);
		}
		else if(o_event.index == 1 && jlist_selected.children.length > 0)
		{
			jlist_selected.prepend(row);
		}
		else
		{
			jlist_selected.append(row);
		}
	}
	else
	{
		jlist_selected.append(row);
	}

	$("#"+o_event.id).dblclick
	(
		function()
		{
			o_event = getEventData($(this).attr("id"));

			listSelected = $("#md-events-ul");

			md_openPopup("index.php?module="+MD_MODULE_NAME+"&view=EditEvent&eventobj="+escape(JSON.stringify(o_event)));
		}
	);
}

function getEventData(event_id)
{
	
	for(var i=0; i<a_events.length; i++)
	{
		if(a_events[i].id == event_id)
		{
			return a_events[i];
		}
	}

	return false;
}

////////////////////
// FILTERS
/////////////////////

function md_addFilter()
{
	var num_filters = jmd_container.find(".md-filter").length;

	o_filter = new Object();
	o_filter.id = "md-filter-"+num_filters;
	o_filter.label = num_filters == 0 ? 'All' : 'LBL_FILTER_'+num_filters;

	row = '<li id="'+o_filter.id+'" class="md-filter">';
	row += '<div class="md-filter-anchor"><div class="md-anchor-out"></div><div class="md-anchor-out"></div><div class="md-anchor-out"></div></div>';
	row += '<input type="text" name="'+o_filter.id+'-label" value="'+o_filter.label+'" '+(o_filter.label == 'All' ? 'readonly="readonly"' : '')+' /> ';
	row += '<ul class="md-filter-fields-ul"></ul>';
	row += '</li>';

	$("#md-filters-ul").append(row);

	jmd_container.find(".md-filter-anchor")
		.hover(
			function() {
				$(this).find("div").attr("class", "md-anchor-over");
			},
			function() {
				$(this).find("div").attr("class", "md-anchor-out");
			}
		)
		.mousedown(function() {
			$("#md-filters-ul").sortable("enable");
		})
		.mouseup(function() {
			$("#md-filters-ul").sortable("disable");
		})
		.hover();

	//Make fields-ul droppable
	jmd_container.find(".md-filter-fields-ul")
		.droppable({
			hoverClass: "md-block-fields-hover",
			connectWith: ".md-fields",
			drop: function( event, ui )
			{
				if(filter_fields_ul_droppable)
				{
					var filter_id = jmd_container.find(".md-filter-field").length;
					
					row = '<li id="md-filter-field-'+filter_id+'" class="md-filter-field">';
					row += $(ui.draggable).text();
					row += '</li>';

					$(this).append(row);
				}
			}
		})
		//Reactivate popup when sort ending
		.sortable({
			connectWith: "ul",
			hoverClass: "md-block-fields-sort",
			start: function( event, ui )
			{
				filter_fields_ul_droppable = false;

				md_showTrash();
			},
			stop: function ( event, ui )
			{
				filter_fields_ul_droppable = true;

				md_hideTrash();
			}
		})
		.disableSelection();
}

function md_addFilterableField(o_field)
{
	var row = '<li>';
	row += o_field.fieldName;
	row += '</li>';

	var jmd_filter_fields_list = $('#md-filter-fields-list');
	jmd_filter_fields_list.append(row);

	//Make modules draggable
	jmd_filter_fields_list.find("li")
		.draggable({
			opacity: 0.7,
			helper: 'clone'
		})
		.disableSelection();

	if(o_field.inFilterAll)
	{
		md_addFieldInFilterAll(o_field);
	}
}

function md_addFieldInFilterAll(o_field)
{	
	jmd_container.find(".md-filter").each
	(
		function()
		{
			if($(this).find("input").val() == 'All')
			{
				var filter_id = $(".md-filter-field").length;
				
				var row = '<li id="md-filter-field-'+filter_id+'" class="md-filter-field">';
				row += o_field.fieldName;
				row += '</li>';

				$(this).find("ul").append(row);
			}
		}
	);
}

/////////////////////

function md_setAllSequences()
{
	//Set blocks and fields sequences
	jmd_container.find(".md-block").each(
		function(block_index)
		{
			var block_id = $(this).attr("id");

			md_setBlockSequence(block_id, block_index+1);

			$(this).find(".md-field").each(
				function(field_index)
				{
					var field_id = $(this).attr("id");

					md_setFieldSequence(field_id, field_index+1);
				}
			)
		}
	);

	//Set custom links sequences
	jmd_container.find(".md-custom-link").each(
		function(customLink_index)
		{
			var customLink_id = $(this).attr("id");

			md_setCustomLinkSequence(customLink_id, customLink_index+1);
		}
	);

	//Set related lists sequences
	jmd_container.find(".md-related-list").each(
		function(relatedList_index)
		{
			var relatedList_id = $(this).attr("id");

			md_setRelatedListSequence(relatedList_id, relatedList_index+1);
		}
	);

	//Set filters sequences
	jmd_container.find(".md-filter").each(
		function(filter_index)
		{
			var filter_id = $(this).attr("id");

			md_setFilterSequence(filter_id, filter_index+1);
		}
	);
}


function md_setBlockSequence(block_id, index)
{
	var found = false;

	for(var i=0; i<a_blocks.length && !found; i++)
	{
		if(a_blocks[i].id == block_id)
		{
			a_blocks[i].index = index;
			found = true;
		}
	}
}

function md_setFieldSequence(field_id, index)
{
	var found = false;

	for(var i=0; i<a_fields.length && !found; i++)
	{
		if(a_fields[i].id == field_id)
		{
			a_fields[i].index = index;
			found = true;
		}
	}
}

function md_setCustomLinkSequence(customLink_id, index)
{
	var found = false;

	for(var i=0; i<a_customLinks.length && !found; i++)
	{
		if(a_customLinks[i].id == customLink_id)
		{
			a_customLinks[i].index = index;
			found = true;
		}
	}
}

function md_setRelatedListSequence(relatedList_id, index)
{
	var found = false;

	for(var i=0; i<a_relatedLists.length && !found; i++)
	{
		if(a_relatedLists[i].id == relatedList_id)
		{
			a_relatedLists[i].index = index;
			found = true;
		}
	}
}

function md_setFilterSequence(filter_id, index)
{
	var found = false;

	for(var i=0; i<a_filters.length && !found; i++)
	{
		if(a_filters[i].id == filter_id)
		{
			a_filters[i].index = index;
			found = true;
		}
	}
}

/////////////////////

function md_makePackage(installModule)
{
	if(md_entityIdentifier == undefined)
	{
		alert(md_vtranslate('LBL_YOU_MUST_DEFINE_A_FIELD_AS_IDENTIFIER'));
		$("#md-tab-blocks-fields").click();
		return;
	}
	
	var md_moduleName				= jmd_container.find("input[name='module_name']").val();
	var md_moduleLabel				= jmd_container.find("input[name='module_name']").val(); //TODO: add a field label
	var md_moduleParentTab			= jmd_container.find("select[name='module_parent_tab']").val() == 'CUSTOM' ? jmd_container.find("input[name='module_parent_tab_name']").val() : jmd_container.find("select[name='module_parent_tab']").val();
	var md_version					= jmd_container.find("input[name='module_version']").val();
	var md_moduleDirectoryTemplate	= jmd_container.find("select[name='module_directory_template']").val();
	var md_moduleManifestTemplate	= jmd_container.find("select[name='module_manifest_template']").val();
	var md_languages				= jmd_container.find("input[name='md-languages']").val();
	var md_modifiedModule			= jmd_container.find("input[name='md_modified_module']").val();
	var md_modifiedModulePath		= jmd_container.find("input[name='md_modified_module_path']").val();

	//Get translations for blocks
	for(var i=0; i<a_blocks.length; i++)
	{
		a_blocks[i].label = jmd_container.find("input[name='"+a_blocks[i].id+"-label']").val();
	}


	//Get filters
	a_filters = [];
	jmd_container.find(".md-filter").each
	(
		function()
		{
			var o_filter = new Object();
			o_filter.name = $(this).find("input").val();
			o_filter.a_fields = [];
			$(this).find("li").each
			(
				function()
				{
					o_filter.a_fields.push($(this).text());
				}
			);
			a_filters.push(o_filter);
		}
	);

	//Some checks for Module 6.0.0 -- TODO: Check if necessary for extension?
    if(md_moduleManifestTemplate === 'module.xml.php' && (md_moduleDirectoryTemplate === '6.0.0' || md_moduleDirectoryTemplate === '6.1.0' || md_moduleDirectoryTemplate === 'Module 6.x'))
    {        
        //Check if some filter have empty field
        var error_filters = false;

        $.each(a_filters, function( index, object ) {
            if(object.a_fields.length === 0)
                error_filters = true;
          });

        if(error_filters)
        {
            alert(app.vtranslate('LBL_EMPTY_FIELD_FILTER', MD_QUALIFIED_MODULE_NAME));
            $("#md-tab-filters").click();
            return false;
        }
    }

	md_setAllSequences();

	var a_postData = {
						'name':md_moduleName,
						'label':md_moduleLabel,
						'parentTab':md_moduleParentTab,
						'version':md_version,
						'defaultTable': md_defaultTable,
						'directoryTemplate':md_moduleDirectoryTemplate,
						'manifestTemplate':md_moduleManifestTemplate,
						'languages':md_languages,
						'modifiedModule':md_modifiedModule,
						'modifiedModulePath':md_modifiedModulePath,
						'a_blocks':a_blocks,
						'a_fields':a_fields,
						'a_customLinks':a_customLinks,
						'a_relatedLists':a_relatedLists,
						'a_events':a_events,
						'a_filters':a_filters
					};

	//Get translations for module's label
	var a_languages = md_languages.split(",");
	$.each
	(
		a_languages,
		function()
		{
			a_postData['label_'+this]			= jmd_container.find("input[name='module_label_"+this+"']").val();
			a_postData['label_single_'+this]	= jmd_container.find("input[name='module_label_single_"+this+"']").val();
		}
	);

	//Custom Handler
	a_postData = md_customHandler(a_postData);

	//Generate a ZIP package
	$.ajax
	(
		{
			url: "index.php?module="+MD_MODULE_NAME+"&action=MakePackage&parent=Settings",
			type: "POST",
			data: {structure: JSON.stringify(a_postData)},
			success: function(data) {				
				if(data.success)
				{
					zip_url = data.result.zipFileName;
	
					if (zip_url) {
						$.ajax({
							url: zip_url,
							type:'HEAD',
							error: function() {
								alert(app.vtranslate('LBL_FILE', MD_QUALIFIED_MODULE_NAME)+' '+zip_url+' '+app.vtranslate('LBL_DOES_NOT_EXIST', MD_QUALIFIED_MODULE_NAME));
							},
							success: function() {
								if(installModule)
								{								
									md_installModule(md_moduleName, md_version, zip_url);
								}
								else
								{
									document.location.href = zip_url;
								}
							}
						});
					} else {
						alert(app.vtranslate('LBL_ERROR_TRY_AGAIN', MD_QUALIFIED_MODULE_NAME));
					}
				}
				else
				{
					console.log(data);
					alert(data.error.message);
				}
			},
			error: function(data) {
				console.log(data);
				alert(app.vtranslate('LBL_ERROR_TRY_AGAIN', MD_QUALIFIED_MODULE_NAME));
			}
		}
	);
}

function md_installModule(moduleName, version, zip_url)
{	
	$.ajax
	(
		{
			url: "index.php?module="+MD_MODULE_NAME+"&action=InstallModule&name="+moduleName+"&version="+version+"&zip="+zip_url+"&parent=Settings",
			type: "GET",
			success: function(data) {				
				if(data.success)
				{
					alert(data.result.message);
				}
				else
				{
					alert(data.error.message);
				}
			},
			error: function(data) {
				console.log(data);
				alert(app.vtranslate('LBL_ERROR_TRY_AGAIN', MD_QUALIFIED_MODULE_NAME));
			}
		}
	);
}

//////////////
//////////////

function md_showTrash()
{
	jmd_container.find(".md-trash").show();
}

function md_hideTrash()
{
	jmd_container.find(".md-trash").hide();
}

function showLoadModulePopup()
{
	md_openPopup("index.php?module="+MD_MODULE_NAME+"&view=GetModules");
}

function showUploadModulePopup()
{
	md_openPopup("index.php?module="+MD_MODULE_NAME+"&view=UploadModule");
}

var o_module;

function md_loadModule(moduleNameOrPath, uploadedModule)
{
	var calledUrl;
	
	if(uploadedModule)
	{
		calledUrl = "index.php?module="+MD_MODULE_NAME+"&action=GetManifestStructure&path="+moduleNameOrPath+"&parent=Settings";
	}
	else
	{
		calledUrl = "index.php?module="+MD_MODULE_NAME+"&action=GetManifestStructure&mod="+moduleNameOrPath+"&parent=Settings";
	}
	
	$.ajax
	(
		{
			url: calledUrl,
			success: function(data)
			{
				if(data.success)
				{
					o_module = data.result.module;
					
					md_selectDirectory(undefined, data.result.module.name, data.result.basedir);
				}
				else
				{
					if(data.error != undefined && data.error.message != undefined)
					{
						alert(data.error.message);
					}
					else
					{
						console.log(data);
						alert(app.vtranslate('LBL_ERROR_TRY_AGAIN', MD_QUALIFIED_MODULE_NAME));
					}
				}				
			},
			error: function(data)
			{	
				console.log(data);
				alert(app.vtranslate('LBL_ERROR_TRY_AGAIN', MD_QUALIFIED_MODULE_NAME));
			}
		}
	);
}

function setModuleData(autoSelectModuleDirectory, moduleDirName)
{	
	if(o_module == undefined)
	{
		return;
	}
	
	//Store module's default table name
	md_defaultTable = o_module.defaultTable;
	
	jmd_container.find("input[name='module_name']").val(o_module.name);
	jmd_container.find("input[name='module_version']").val(o_module.version);
	jmd_container.find("select[name='module_parent_tab'] option[value='"+o_module.parent+"']").attr("selected", "selected");
	
	if(o_module.type != undefined)
	{
		if(o_module.type == 'extension')
		{
			jmd_container.find("select[name='module_manifest_template'] option[value='extension.xml.php']").attr("selected", "selected");
		}
		else
		{
			jmd_container.find("select[name='module_manifest_template'] option[value='module.xml.php']").attr("selected", "selected");
		}
	}

	if(autoSelectModuleDirectory)
	{
		if(jmd_container.find("select[name='module_directory_template'] option[value='EXISTANT'").length == 0 )
		{
			jmd_container.find("select[name='module_directory_template']").append('<option value="EXISTANT">'+app.vtranslate('LBL_MODULE_FOLDER', MD_QUALIFIED_MODULE_NAME)+'</option>');
		}
		jmd_container.find("select[name='module_directory_template'] option[value='EXISTANT']").attr("selected", "selected");
		
		jmd_container.find("input[name='md_modified_module']").val(o_module.name);
		jmd_container.find("input[name='md_modified_module_path']").val(moduleDirName);
		jmd_container.find("input[name='old_module_table_name']").val('vtiger_'+o_module.name.toLowerCase());
	}
	else
	{
		jmd_container.find("input[name='md_modified_module']").val('');
		jmd_container.find("input[name='md_modified_module_path']").val('');
	}
	

	var md_languages = jmd_container.find("input[name='md-languages']").val();
	
	var a_languages = md_languages.split(",");

	$.each
	(
		a_languages,
		function()
		{
			jmd_container.find("input[name='module_label_"+this+"']").val(o_module['label_'+this]);
			jmd_container.find("input[name='module_label_single_"+this+"']").val(o_module['label_single_'+this]);
		}
	);


	//Remove all blocks
	jmd_container.find(".md-block").remove();

	//Remove all custom links
	jmd_container.find(".md-custom-link").remove();

	//Remove all related lists
	jmd_container.find(".md-related-list").remove();

	//Remove all events
	jmd_container.find(".md-event").remove();
	
	//Remove all fields from filter fields list
	jmd_container.find('#md-filter-fields-list li').remove();

	//Remove all filters and create an empty one
	jmd_container.find(".md-filter").remove();
	md_addFilter();


	//Reinitialize
	a_blocks = [];
	a_fields = [];
	a_customLinks = [];
	a_relatedLists = [];
	a_events = [];
	a_filters = [];

	//Create blocks
	for(var i=0; i<o_module.a_blocks.length; i++)
	{
		md_addBlock(o_module.a_blocks[i], true);
	}

	//Create fields
	for(var j=0; j<o_module.a_fields.length; j++)
	{
		var a_fieldId = o_module.a_fields[j].id.split("-");
		var blockNum = a_fieldId[2];

		blockEdited = $("#md-block-"+blockNum+" ul");

		md_addField(o_module.a_fields[j], true);
	}

	//Create custom links
	for(var l=0; l<o_module.a_customLinks.length; l++)
	{
		listSelected = $("#md-custom-links-ul");

		md_addCustomLink(o_module.a_customLinks[l], true);
	}

	//Create related lists
	for(var m=0; m<o_module.a_relatedLists.length; m++)
	{
		listSelected = $("#md-related-lists-ul");

		md_addRelatedList(o_module.a_relatedLists[m], true);
	}

	//Create events
	for(var n=0; n<o_module.a_events.length; n++)
	{
		listSelected = $("#md-events-ul");

		md_addEvent(o_module.a_events[n], true);
	}

	//Add filter All
	// for(var o=0; o<o_module.a_filterAll.length; o++)
	// {
		// var row = '<li>';
		// row += o_module.a_filterAll[o];
		// row += '</li>';
// 
		// jmd_container.find(".md-filter ul").append(row);
	// }

	//Load custom JS method
	md_LoadModuleCustom(o_module);
}

function md_vtranslate(string)
{
	return app.vtranslate(string);
}
