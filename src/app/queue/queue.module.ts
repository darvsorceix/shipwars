import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {RouterModule} from '@angular/router';
import {QueueComponent} from './queue.component';
import {QueueRoutingModule} from './queue-routing.module';

@NgModule({
    imports: [
        CommonModule,
        RouterModule,
        QueueRoutingModule
    ],
    exports: [
        QueueComponent
    ],
    declarations: [QueueComponent]
})
export class QueueModule {
}
