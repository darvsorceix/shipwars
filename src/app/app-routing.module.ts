import {NgModule} from '@angular/core';
import {Route, RouterModule} from '@angular/router';
import {HomeComponent} from './main/home/home.component';
import {AboutComponent} from './main/about/about.component';
import {AuthGuard} from './auth/auth.guard';

const APP_ROUTES: Route[] = [
    {path: '', pathMatch: 'full', redirectTo: 'home'},
    {path: 'home', component: <any>HomeComponent},
    {path: 'about', component: <any>AboutComponent},
    {path: 'start', canLoad: [AuthGuard], loadChildren: 'app/logged/logged.module#LoggedModule'},
    {path: 'game', canLoad: [AuthGuard], loadChildren: 'app/queue/queue.module#QueueModule'},
    {path: 'play', canLoad: [AuthGuard], loadChildren: 'app/play/play.module#PlayModule'},
    {path: 'stats', canLoad: [AuthGuard], loadChildren: 'app/stats/stats.module#StatsModule'},
];

@NgModule({
    imports: [
        RouterModule.forRoot(APP_ROUTES),
    ],
    exports: [
        RouterModule
    ]
})

export class AppRoutingModule {
}
