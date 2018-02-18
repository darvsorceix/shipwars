import {NgModule} from '@angular/core';
import {Route, RouterModule} from '@angular/router';
import {QueueComponent} from './queue.component';

const QUEUE_ROUTES: Route[] = [
    {
        path: '',
        component: <any>QueueComponent
    }
];

@NgModule({
    imports: [
        RouterModule.forChild(QUEUE_ROUTES),
    ],
    exports: [
        RouterModule
    ]
})

export class QueueRoutingModule {
}
