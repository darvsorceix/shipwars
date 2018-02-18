import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';

@Component({
    selector: 'sw-home',
    templateUrl: './home.component.html',
    styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

    constructor(private router: Router) {
    }

    authKey = '';

    ngOnInit() {
        this.authKey = localStorage.getItem('auth_key');
        if (this.authKey !== null) {
            this.router.navigate(['/start']);
        }
    }

}
