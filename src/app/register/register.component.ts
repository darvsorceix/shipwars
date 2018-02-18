import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {HttpClient} from '@angular/common/http';
import {matchOtherValidator} from '../validators/sw-validators/sw-validators';
import {Router} from '@angular/router';

@Component({
    selector: 'sw-register',
    templateUrl: './register.component.html',
    styleUrls: ['./register.component.scss']
})

export class RegisterComponent implements OnInit {
    registerForm: FormGroup;
    actionResult = '';
    error = false;
    success = false;
    authKey = '';
    private API = 'http://localhost/ships/db/register.php';

    constructor(private formBuilder: FormBuilder, private http: HttpClient, private router: Router) {
    }

    ngOnInit() {
        this.registerForm = this.buildRegisterForm();

        this.authKey = localStorage.getItem('auth_key');
        if (this.authKey !== null) {
            this.router.navigate(['/start']);
        }
    }

    buildRegisterForm() {
        return this.formBuilder.group({
            email: ['', Validators.required],
            login: ['', Validators.required],
            password: ['', [Validators.required, Validators.minLength(6)]],
            rPassword: ['', [Validators.required, Validators.minLength(6), matchOtherValidator('password')]],
        });
    }

    addUser(data) {
        this.http.post(this.API, {
            email: data.email,
            login: data.login,
            password: data.password
        })
            .subscribe(
                result => {
                    if (result === 1) {
                        this.success = true;
                        this.registerForm.reset();
                    }
                    if (result['email'] === 1) {
                        this.error = true;
                        this.actionResult = 'Email is already taken';
                    }
                    if (result['login'] === 1) {
                        this.error = true;
                        this.actionResult = 'Login is already taken';
                    }
                },
                err => {
                    console.log(err);
                }
            );
    }
}
