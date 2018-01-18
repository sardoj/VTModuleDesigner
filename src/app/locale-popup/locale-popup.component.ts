import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

@Component({
  selector: 'app-locale-popup',
  templateUrl: './locale-popup.component.html',
  styleUrls: ['./locale-popup.component.scss']
})
export class LocalePopupComponent {

  constructor(
    public dialogRef: MatDialogRef<LocalePopupComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
  }

}
