import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {RouterModule} from '@angular/router';
import {StatsComponent} from './stats.component';
import {StatsRoutingModule} from './stats-routing.module';

@NgModule({
    imports: [
        CommonModule,
        RouterModule,
        StatsRoutingModule
    ],
    exports: [
        StatsComponent
    ],
    declarations: [StatsComponent]
})
export class StatsModule {
}
