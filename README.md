VTModuleDesigner
================

> *************************************************************************************************************
> Download Module Designer 1.0 RC: [http://www.mediatoolbox.org](http://www.mediatoolbox.org)
> *************************************************************************************************************

> *************************************************************************************************************
> Don't forget to install vtlib patch!!! You can find in the "patch" folder, files to replace in your CRM.
> *************************************************************************************************************

# How to
Video tutorial : [http://youtu.be/PF3noyh7M-g](http://youtu.be/PF3noyh7M-g)

# Customize your Module Designer
Module Designer for Vtiger 6

You can set your own fields and variables. To do this modify these files:
- /vlayouts/layout/Settings/ModuleDesigner/Custom.tpl
- /vlayouts/layout/Settings/ModuleDesigner/resources/CustomScript.js
- /modules/ModuleDesigner/CustomManifestStructure.php

You can also create plugins to handle your variables, in the directory /modules/ModuleDesigner/plugins

#v1.0 RC Change log:
- Icon added for ModuleDesigner
- HTML special chars bug fix
- It is now possible to modify Vtiger Core’s modules
- Templates directories are now called Module 6.x and Extension 6.x
- Only translation into default language is mandatory
- Select automatically manifest template after loading an existant module
- Several tabs are closed for extensions
- Trash less on the bottom of the page
- Help info field bug fix
- Remove of Custom menu
- UTF-8 chars bug fix
- For an existant module in the class of the module, vtlib_getModuleNameById() it is not replaced anymore
- During creation of new modules, it is now possible, for UIType fields, to create automatically a Related List in the destination module
- Custom fields are now in manifest.xml
- Multiple tables are now in manifest.xml
- Field’s name « name » is not allowed anymore
- It is now mandatory to define a field as identifier
- It is now not possible to define several fields as identifier