import {NgModule} from "@angular/core";
import {Route, RouterModule} from "@angular/router";
import {PlayComponent} from "./play.component";

const PLAY_ROUTES: Route[] = [
    {
        path: '',
        component: <any>PlayComponent
    }
];

@NgModule({
    imports: [
        RouterModule.forChild(PLAY_ROUTES),
    ],
    exports: [
        RouterModule
    ]
})

export class PlayRoutingModule {
}
