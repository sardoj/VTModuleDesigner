import { Component, Inject } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { LocalePopupComponent } from './locale-popup/locale-popup.component';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { isNullOrUndefined } from 'util';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'ModuleDesigner';

  mode = 'expert';

  // TODO : set dynamicaly
  a_locales = [
    { code: 'en_us', active: true },
    { code: 'fr_fr', active: false }
  ];

  a_uiTypes = [
    { uitype: 1, label: 'uitype.textInput'},
    { uitype: 4, label: 'uitype.autoNumber'},
    { uitype: 5, label: 'uitype.date'},
    { uitype: 7, label: 'uitype.numericImput'},
    { uitype: 9, label: 'uitype.percentageImput'},
    { uitype: 10, label: 'uitype.relatedModule'},
    { uitype: 13, label: 'uitype.emailInput'},
    { uitype: 15, label: 'uitype.pickListSecurised'},
    { uitype: 16, label: 'uitype.pickList'},
    { uitype: 33, label: 'uitype.pickListMultiple'},
    { uitype: 17, label: 'uitype.url'},
    { uitype: 19, label: 'uitype.textArea', width: 2},
    { uitype: 21, label: 'uitype.textAreaSmall'},
    { uitype: 56, label: 'uitype.boolean'},
    { uitype: 71, label: 'uitype.amount'}
  ]; 

  a_blocks = [];

  constructor(private translate: TranslateService) {
    // This language will be used as a fallback when a translation isn't found in the current language
    translate.setDefaultLang('en');

     // The lang to use, if the lang isn't available, it will use the current loader to get them
    translate.use('en');

    this.addBlock('LBL_BLOCK_GENERAL_INFORMATION');
  }

  addBlock(label?: string)
  {
    const block = {
      label: label,
      a_fields: []
    };

    this.a_blocks.push(block);
  }

  onItemDrop(e: any, block: any) {
    // N.B: e.dragData contains data about the item dropped

    // Create a new field into the selected block
    const field = {
      fieldname: e.dragData.label,
      uitype: e.dragData.uitype,
      width: e.dragData.width ? e.dragData.width : 1
    };

    block.a_fields.push(field);
}

  // openLanguageDialog(): void {
  //   let dialogRef = this.dialog.open(LocalePopupComponent1, {
  //     width: '250px',
  //     // data: { name: this.name, animal: this.animal }
  //   });

  //   dialogRef.afterClosed().subscribe(result => {
  //     // this.animal = result;
  //   });
  // }
}