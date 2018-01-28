import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModuleDesignerComponent } from './module-designer.component';

describe('ModuleDesignerComponent', () => {
  let component: ModuleDesignerComponent;
  let fixture: ComponentFixture<ModuleDesignerComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModuleDesignerComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModuleDesignerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
