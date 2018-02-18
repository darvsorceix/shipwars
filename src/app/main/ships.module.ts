import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {HomeComponent} from './home/home.component';
import {AboutComponent} from './about/about.component';
import {RouterModule} from '@angular/router';

@NgModule({
    imports: [
        CommonModule,
        RouterModule
    ],
    exports: [
        HomeComponent,
        AboutComponent,
    ],
    declarations: [
        HomeComponent,
        AboutComponent,
    ]
})
export class ShipsModule {
}
