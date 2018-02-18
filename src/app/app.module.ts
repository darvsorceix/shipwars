import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {AppComponent} from './app.component';
import {ShipsModule} from './main/ships.module';
import {AppRoutingModule} from './app-routing.module';
import {LoginModule} from './login/login.module';
import {RegisterModule} from './register/register.module';
import {RegisterRoutingModule} from './register/register-routing.module';
import {AuthService} from './auth/auth.service';
import {AuthGuard} from './auth/auth.guard';


@NgModule({
    declarations: [
        AppComponent,
    ],
    imports: [
        BrowserModule,
        ShipsModule,
        AppRoutingModule,
        LoginModule,
        RegisterModule,
        RegisterRoutingModule,
    ],
    providers: [AuthService, AuthGuard],
    bootstrap: [AppComponent]
})
export class AppModule {
}
