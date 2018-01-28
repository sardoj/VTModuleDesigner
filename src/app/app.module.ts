import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule, HttpClient } from '@angular/common/http';
import { TranslateModule, TranslateLoader } from '@ngx-translate/core';
import { TranslateHttpLoader } from '@ngx-translate/http-loader';
import { FlexLayoutModule } from '@angular/flex-layout';
import { NgDragDropModule } from 'ng-drag-drop';
import { FormsModule } from '@angular/forms';

import {
  MatTabsModule,
  MatCardModule,
  MatInputModule,
  MatButtonModule,
  MatIconModule,
  MatDialogModule,
  MatSelectModule,
  MatTooltipModule,
  MatChipsModule
} from '@angular/material';


import { AppComponent } from './app.component';
import { LocalePopupComponent } from './locale-popup/locale-popup.component';
import { ModuleDesignerComponent } from './module-designer/module-designer.component';
import { FieldPopupComponent } from './field-popup/field-popup.component';

// AoT requires an exported function for factories
export function HttpLoaderFactory(http: HttpClient) {
  return new TranslateHttpLoader(http);
}


@NgModule({
  declarations: [
    AppComponent,
    LocalePopupComponent,
    ModuleDesignerComponent,
    FieldPopupComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    HttpClientModule,
    FlexLayoutModule,
    FormsModule,
    NgDragDropModule.forRoot(),
    TranslateModule.forRoot({
      loader: {
          provide: TranslateLoader,
          useFactory: HttpLoaderFactory,
          deps: [HttpClient]
      }
    }),
    // Material components
    MatTabsModule,
    MatCardModule,
    MatInputModule,
    MatButtonModule,
    MatIconModule,
    MatDialogModule,
    MatSelectModule,
    MatTooltipModule,
    MatChipsModule
  ],
  entryComponents: [
    LocalePopupComponent,
    FieldPopupComponent
  ],
  providers: [],
  bootstrap: [ AppComponent ]
})
export class AppModule { }
