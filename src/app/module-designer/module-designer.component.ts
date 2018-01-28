import { Component, OnInit } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { LocalePopupComponent } from '../locale-popup/locale-popup.component';
import { MatDialog } from '@angular/material';
import { isNullOrUndefined } from 'util';

import axios from 'axios';
import { environment } from '../../environments/environment';
import { FieldPopupComponent } from '../field-popup/field-popup.component';

@Component({
  selector: 'app-module-designer',
  templateUrl: './module-designer.component.html',
  styleUrls: ['./module-designer.component.scss']
})
export class ModuleDesignerComponent implements OnInit {

  config = {
    isExpertMode: true,
    a_locales: [ // TODO : set dynamicaly
      { code: 'en_us', active: true },
      { code: 'fr_fr', active: false }
    ]
  };

  a_uiTypes = [
    { uitype: 1, label: 'uitype.textInput', columnType: 'VARCHAR(100)'},
    { uitype: 4, label: 'uitype.autoNumber', columnType: 'VARCHAR(100)', advancedSettings: true},
    { uitype: 5, label: 'uitype.date', columnType: 'DATE'},
    { uitype: 7, label: 'uitype.numericImput', columnType: 'INT(11)', advancedSettings: true},
    { uitype: 9, label: 'uitype.percentageImput', columnType: 'DECIMAL(15,2)'},
    { uitype: 10, label: 'uitype.relatedModule', columnType: 'INT(11)', advancedSettings: true},
    { uitype: 13, label: 'uitype.emailInput', columnType: 'VARCHAR(100)'},
    { uitype: 15, label: 'uitype.pickListSecurised', columnType: 'VARCHAR(100)', advancedSettings: true},
    { uitype: 16, label: 'uitype.pickList', columnType: 'VARCHAR(100)', advancedSettings: true},
    { uitype: 33, label: 'uitype.pickListMultiple', columnType: 'VARCHAR(100)', advancedSettings: true},
    { uitype: 17, label: 'uitype.url', columnType: 'VARCHAR(100)'},
    { uitype: 19, label: 'uitype.textArea', width: 2, columnType: 'TEXT'},
    { uitype: 21, label: 'uitype.textAreaSmall', columnType: 'VARCHAR(255)'},
    { uitype: 56, label: 'uitype.boolean', columnType: 'INT(1)'},
    { uitype: 71, label: 'uitype.amount', columnType: 'DECIMAL(15,2)'}
  ];

  module = {
    name: '',
    version: '1.0.0',
    singularTranslation: {},
    pluralTranslation: {},
    a_blocks: []
  };

  constructor(private translate: TranslateService, private dialog: MatDialog) {
    
  }

  ngOnInit()
  {
    // This language will be used as a fallback when a translation isn't found in the current language
    this.translate.setDefaultLang('en');

     // The lang to use, if the lang isn't available, it will use the current loader to get them
     this.translate.use('en');

    this.getConfig();

    this.addBlock('LBL_BLOCK_GENERAL_INFORMATION');
  }

  getConfig()
  {
    axios.get(`${environment.rootUrl}/index.php?module=ModuleDesigner&parent=Settings&action=GetConfig`).then((response) => {
      if (response.data && response.data.success) {
        this.config = response.data.result;
      }
    });
  }

  changeModuleName() {
    // Sanitize module name
    this.module.name = this.module.name.replace(/[^0-9a-zA-Z]/g, '');
  }

  addBlock(label?: string)
  {
    const block = {
      label: label,
      a_fields: []
    };

    this.module.a_blocks.push(block);
  }

  onItemDrop(e: any, block: any) {
    // N.B: e.dragData contains data about the item dropped

    // Create a new field into the selected block
    const field = {
      fieldname: e.dragData.label,
      uitype: e.dragData.uitype,
      width: e.dragData.width ? e.dragData.width : 1
    };

    //block.a_fields.push(field);

    this.openFieldDialog(block, e.dragData);
  }

  openLocaleDialog(): void {
    let dialogRef = this.dialog.open(LocalePopupComponent, {
      width: '250px',
      data: { config: this.config }
    });

    dialogRef.afterClosed().subscribe(result => {
      // this.animal = result;
    });
  }

  openFieldDialog(block, uiType): void {
    let dialogRef = this.dialog.open(FieldPopupComponent, {
      width: '700px',
      data: {
        config: this.config,
        module: this.module,
        block: block,
        uiType: uiType
      }
    });

    dialogRef.afterClosed().subscribe(result => {
      // this.animal = result;
      //block.a_fields.push(field);
    });
  }

}
