import {NgModule} from '@angular/core';
import {Route, RouterModule} from '@angular/router';
import {StatsComponent} from './stats.component';

const STATS_ROUTES: Route[] = [
    {
        path: '',
        component: <any>StatsComponent,
    }
];

@NgModule({
    imports: [
        RouterModule.forChild(STATS_ROUTES),
    ],
    exports: [
        RouterModule
    ]
})

export class StatsRoutingModule {
}
