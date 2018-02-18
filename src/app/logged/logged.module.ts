import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {RouterModule} from '@angular/router';
import {LoggedComponent} from './logged.component';
import {LoggedRoutingModule} from './logged-routing.module';

@NgModule({
    imports: [
        CommonModule,
        RouterModule,
        LoggedRoutingModule
    ],
    exports: [
        LoggedComponent
    ],
    declarations: [LoggedComponent]
})
export class LoggedModule {
}
