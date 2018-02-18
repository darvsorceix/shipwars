import {NgModule} from '@angular/core';
import {Route, RouterModule} from '@angular/router';
import {LoggedComponent} from './logged.component';

const LOGGED_ROUTES: Route[] = [
    {
        path: '',
        component: <any>LoggedComponent
    }
];

@NgModule({
    imports: [
        RouterModule.forChild(LOGGED_ROUTES),
    ],
    exports: [
        RouterModule
    ]
})

export class LoggedRoutingModule {
}
