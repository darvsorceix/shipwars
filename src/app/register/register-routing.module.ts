import {NgModule} from '@angular/core';
import {Route, RouterModule} from '@angular/router';
import {RegisterComponent} from './register.component';

const REGISTER_ROUTES: Route[] = [
    {
        path: 'register',
        component: <any>RegisterComponent,
    }
];

@NgModule({
    imports: [
        RouterModule.forChild(REGISTER_ROUTES),
    ],
    exports: [
        RouterModule
    ]
})

export class RegisterRoutingModule {
}
