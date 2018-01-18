import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LocalePopupComponent } from './locale-popup.component';

describe('LocalePopupComponent', () => {
  let component: LocalePopupComponent;
  let fixture: ComponentFixture<LocalePopupComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LocalePopupComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LocalePopupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
