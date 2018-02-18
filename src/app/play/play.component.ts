import {Component, Renderer2, OnInit, OnDestroy} from '@angular/core';
import {Router} from '@angular/router';
import {HttpClient} from '@angular/common/http';

@Component({
    selector: 'sw-play',
    templateUrl: './play.component.html',
    styleUrls: ['./play.component.scss']

})
export class PlayComponent implements OnInit, OnDestroy {
    constructor(private renderer: Renderer2, private router: Router, private http: HttpClient) {
    }

    private API = 'http://localhost/ships/db/game.php';
    private API2 = 'http://localhost/ships/db/play.php';

    userLogin = localStorage.getItem('login');
    authKey = localStorage.getItem('auth_key');
    enemy = '';
    private loop;
    turn = false;
    win = false;
    lost = false;
    i = 0;
    array = [];

    ngOnInit() {
        this.http.post(this.API, {
            game: this.authKey
        }).subscribe(
            data => {
                if (data['result'] === 0) {
                    this.router.navigate(['/game']);
                } else if (data['result'] === 4) {
                    this.enemy = data['enemy'];
                }
            },
            err => {
            });

        this.checkForMove();

        this.loop = setInterval(() => {
            this.checkForMove();
        }, 5000);

        this.array = this.createArray(1, 25);
    }

    ngOnDestroy() {
        clearInterval(this.loop);
    }

    createArray(a, b) {

        this.i = a;

        while ((this.array[this.array.length] = this.i) < b) {
            this.i++;
        }
        return this.array;
    }

    shotToField(event: any) {
        this.http.post(this.API2, {
            player: this.authKey,
            hit: event.target.id
        }).subscribe(
            data => {
                if (data['hit'] === 1) {
                    this.renderer.addClass(event.target, 'hit');
                    this.turn = false;
                    this.win = true;
                    clearInterval(this.loop);
                } else {
                    this.renderer.addClass(event.target, 'miss');
                    this.turn = false;
                }
            },
            err => {
            });
    }

    checkForMove() {
        this.http.post(this.API2, {
            player: this.authKey
        }).subscribe(
            data => {
                if (data['turn'] === 1) {
                    this.turn = true;
                } else if (data['turn'] === 0) {
                    this.turn = false;
                } else if (data['turn'] === 3) {
                    this.turn = false;
                    this.lost = true;
                }
            },
            err => {
            });
    }
}
