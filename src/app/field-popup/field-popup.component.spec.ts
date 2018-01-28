import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { FieldPopupComponent } from './field-popup.component';

describe('FieldPopupComponent', () => {
  let component: FieldPopupComponent;
  let fixture: ComponentFixture<FieldPopupComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ FieldPopupComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(FieldPopupComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
