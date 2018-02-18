import {Component, OnInit} from '@angular/core';
import {AuthService} from '../auth/auth.service';
import {Router} from '@angular/router';
import {HttpClient} from "@angular/common/http";

@Component({
    selector: 'sw-stats',
    templateUrl: './stats.component.html',
    styleUrls: ['./stats.component.scss']
})
export class StatsComponent implements OnInit {

    constructor(private http: HttpClient) {
    }

    authKey = localStorage.getItem('auth_key');
    userLogin = localStorage.getItem('login');
    private API = 'http://localhost/ships/db/game.php';
    total = 0;
    won = 0;

    ngOnInit() {

        this.http.post(this.API, {
            stats: this.authKey
        }).subscribe(
            res => {
                this.total = res['total'];
                this.won = res['won'];
            },
            err => {
                console.log(err);
            });
    }
}
