import {Component, OnInit} from '@angular/core';
import {AuthService} from '../auth/auth.service';
import {Router} from '@angular/router';

@Component({
    selector: 'sw-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

    email = '';
    password = '';
    actionResult = '';
    error = false;
    authKey = '';

    constructor(private authService: AuthService, private router: Router) {

    }

    ngOnInit() {
        this.authKey = localStorage.getItem('auth_key');
        if (this.authKey !== null) {
            this.authService.logged(this.authKey)
                .then(this.onSubmitSuccess.bind(this), this.onSubmitFailure.bind(this));
        }
    }

    onSubmit() {
        if (this.email === '' || this.password === '') {
            this.error = false;
        } else {
            this.authService.login(this.email, this.password)
                .then(this.onSubmitSuccess.bind(this), this.onSubmitFailure.bind(this));
        }
    }

    private onSubmitSuccess() {
        localStorage.setItem('email', this.email);
        this.router.navigate(['/start']);
    }

    private onSubmitFailure() {
        this.error = true;
        this.actionResult = 'Incorrect login or password.';
    }
}

