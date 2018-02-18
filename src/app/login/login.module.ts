import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {LoginComponent} from './login.component';
import {FormsModule} from "@angular/forms";
import {RouterModule} from "@angular/router";
import {LoginRoutingModule} from "./login-routing.module";
import {HttpClientModule} from "@angular/common/http";


@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        RouterModule,
        LoginRoutingModule,
        HttpClientModule
    ],
    exports: [
        LoginComponent
    ],
    declarations: [LoginComponent]
})
export class LoginModule {
}
