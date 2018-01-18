import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule, HttpClient } from '@angular/common/http';
import { TranslateModule, TranslateLoader } from '@ngx-translate/core';
import { TranslateHttpLoader } from '@ngx-translate/http-loader';
import { FlexLayoutModule } from '@angular/flex-layout';
import { NgDragDropModule } from 'ng-drag-drop';

import {
  MatTabsModule,
  MatCardModule,
  MatInputModule,
  MatButtonModule,
  MatIconModule
} from '@angular/material';


import { AppComponent } from './app.component';
import { LocalePopupComponent } from './locale-popup/locale-popup.component';

// AoT requires an exported function for factories
export function HttpLoaderFactory(http: HttpClient) {
  return new TranslateHttpLoader(http);
}


@NgModule({
  declarations: [
    AppComponent,
    LocalePopupComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    HttpClientModule,
    FlexLayoutModule,
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
    MatIconModule
  ],
  entryComponents: [
    LocalePopupComponent
  ],
  providers: [],
  bootstrap: [ AppComponent ]
})
export class AppModule { }
