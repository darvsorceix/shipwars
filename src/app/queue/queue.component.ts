import {Component, OnInit, OnDestroy} from '@angular/core';
import {Router} from '@angular/router';
import {HttpClient} from '@angular/common/http';

@Component({
    selector: 'sw-game',
    templateUrl: './queue.component.html',
    styleUrls: ['./queue.component.scss']
})
export class QueueComponent implements OnInit, OnDestroy {

    constructor(private router: Router, private http: HttpClient) {
    }

    private API = 'http://localhost/ships/db/game.php';
    private CRON = 'http://localhost/ships/db/cron.php';

    userLogin = localStorage.getItem('login');
    authKey = localStorage.getItem('auth_key');

    peopleOnline = 0;
    result = '00:00';
    time = 0;
    loop;
    loop2;
    accept = false;
    wait = false;

    ngOnInit() {
        this.check();
        this.joinQueue();
        this.searchPlayers();
        this.queueTime();
        this.searchingPlayers();
    }

    ngOnDestroy() {
        clearInterval(this.loop);
        clearInterval(this.loop2);
    }

    str_pad_left(string, pad, length) {
        return (new Array(length + 1).join(pad) + string).slice(-length);
    }

    searchPlayers() {
        this.http.post(this.API, {
            information: true
        }).subscribe(
            res => {
                this.peopleOnline = res['queue_people'];
            });
    }

    runCron() {
        this.http.post(this.CRON, {
            information: true
        }).subscribe(
            res => {
            });
    }


    joinQueue() {
        this.http.post(this.API, {
            key: this.authKey
        }).subscribe(
            res => {
                if (res['result'] === '1') {
                    console.log('Added');
                }
                if (res['result'] === '3') {
                    console.log('MATCH');
                    if (this.wait === false) {
                        this.accept = true;
                    }
                }
                if (res['result'] === '4') {
                    this.router.navigate(['/play']);
                }
            },
            err => {
                console.log(err);
            });
    }

    queueTime() {
        this.loop = setInterval(() => {
            this.time = this.time + 1;
            const minutes = Math.floor(this.time / 60);
            const seconds = this.time - minutes * 60;

            this.result = this.str_pad_left(minutes, '0', 2) + ':' + this.str_pad_left(seconds, '0', 2);
        }, 1000);
    }

    searchingPlayers() {
        this.loop2 = setInterval(() => {
            this.searchPlayers();
            this.joinQueue();
            this.check();
        }, 5000);

    }

    acceptance() {
        this.http.post(this.API, {
            play: this.authKey
        }).subscribe(
            res => {
                if (res['result'] === '1') {
                    this.wait = true;
                    this.accept = false;
                    this.check();
                }
                if (res['result'] === '4') {
                    this.router.navigate(['/play']);
                }
            },
            err => {
                console.log(err);
            });
    }

    check() {
        this.http.post(this.API, {
            redirect: this.authKey
        }).subscribe(
            checking => {
                if (checking['result'] === '4') {
                    this.router.navigate(['/play']);
                } else {
                    console.log('RESULT = ' + checking['result']);
                }
            },
            err => {
            });
    }
}
