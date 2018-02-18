import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {RouterModule} from "@angular/router";
import {PlayComponent} from "./play.component";
import {PlayRoutingModule} from "./play-routing.module";


@NgModule({
    imports: [
        CommonModule,
        RouterModule,
        PlayRoutingModule
    ],
    exports: [
        PlayComponent
    ],
    declarations: [PlayComponent]
})
export class PlayModule {
}
