import {Component, OnInit} from '@angular/core';
import {AuthService} from '../auth/auth.service';
import {Router} from '@angular/router';

@Component({
    selector: 'sw-logged',
    templateUrl: './logged.component.html',
    styleUrls: ['./logged.component.scss']
})
export class LoggedComponent implements OnInit {

    constructor(private authService: AuthService, private router: Router) {
    }
    authKey = localStorage.getItem('auth_key');
    userLogin = localStorage.getItem('login');

    ngOnInit() {}

    logOut() {
        this.authService.logOut();
        this.router.navigate(['/home']);
    }

}
