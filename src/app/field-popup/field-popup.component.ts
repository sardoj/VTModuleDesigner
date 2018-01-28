import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MatChipInputEvent } from '@angular/material';
import { ENTER, COMMA } from '@angular/cdk/keycodes';

@Component({
  selector: 'app-field-popup',
  templateUrl: './field-popup.component.html',
  styleUrls: ['./field-popup.component.scss']
})
export class FieldPopupComponent {

  // Enter, comma
  separatorKeysCodes = [ENTER, COMMA];

  field = {
    uiType: null,
    fieldName: '',
    fieldLabel: 'LBL_',
    tableName: 'vtiger_',
    columnName: '',
    columnType: '',
    defaultValue: '',
    displayType: 1,
    mandatory: false,
    listView: false,
    quickCreate: false,
    massEdit: false,
    header: false,
    keyField: false,
    translation: {},
    autoNumberPrefix: null, // Auto number
    autoNumberStartSequence: null, // Auto number
    numberType: null, // Number
    relatedModules: null, // Related module
    pickListOptions: null, // Pick List
    pickListOptionsTranslations: null, // Pick List
  };

  constructor(
    public dialogRef: MatDialogRef<FieldPopupComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any) {

      this.field.uiType = data.uiType.uitype;
      this.field.columnType = data.uiType.columnType;

      this.field.tableName = 'vtiger_' + data.module.name.toLowerCase();

      // Auto number
      if (this.field.uiType === 4) {
        this.field.autoNumberStartSequence = 1; // Start from 1
      }

      // Number
      if (this.field.uiType === 7) {
        this.field.numberType = 'I'; // Integer
      }

      // Related module
      if (this.field.uiType === 10) {
        this.field.relatedModules = []; // Initialize list
      }

      // Pick List
      if (this.field.uiType === 15 || this.field.uiType === 16 || this.field.uiType === 33) {
        this.field.pickListOptions = []; // Initialize list
        this.field.pickListOptionsTranslations = {}; // Initialize list
      }
    }

  onNoClick(): void {
    this.dialogRef.close();
  }

  changeFieldName() {
    // Sanitize field name
    this.field.fieldName = this.field.fieldName.toLowerCase().replace(/[^0-9a-z]/g, '_');

    // Set column name
    this.field.columnName = this.field.fieldName.toLowerCase();

    // Set field label
    this.field.fieldLabel = 'LBL_' + this.field.fieldName.toUpperCase();
  }

  changeFieldLabel() {
    // Sanitize field label
    this.field.fieldLabel = this.field.fieldLabel.toUpperCase().replace(/[^0-9A-Z]/g, '_');
  }

  changeColumnName() {
    // Sanitize column name
    this.field.columnName = this.field.columnName.toLowerCase().replace(/[^0-9a-z]/g, '_');
  }

  changeTableName() {
    // Sanitize table name
    this.field.tableName = this.field.tableName.toLowerCase().replace(/[^0-9a-z]/g, '_');
  }

  addPickListOption(event: MatChipInputEvent): void {
    let input = event.input;
    let value = event.value;

    // Add our fruit
    if ((value || '').trim()) {
      this.field.pickListOptions.push(value.trim());
    }

    // Reset the input value
    if (input) {
      input.value = '';
    }
  }

  removePickListOption(option: any): void {
    let index = this.field.pickListOptions.indexOf(option);

    if (index >= 0) {
      this.field.pickListOptions.splice(index, 1);
    }
  }

  addPickListOptionTranslation(event: MatChipInputEvent): void {
    let input = event.input;
    let value = event.value;

    // Add our fruit
    if ((value || '').trim()) {
      this.field.pickListOptionsTranslations.push(value.trim());
    }

    // Reset the input value
    if (input) {
      input.value = '';
    }
  }

  removePickListOptionTranslation(translation: any): void {
    let index = this.field.pickListOptions.indexOf(translation);

    if (index >= 0) {
      this.field.pickListOptionsTranslations.splice(index, 1);
    }
  }

}
