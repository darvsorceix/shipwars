import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";

@Injectable()
export class AuthService {

    constructor(private http: HttpClient) {
    }

    private isUserLoggedIn = false;
    private API = 'http://localhost/ships/db/login.php';

    login(email, password) {
        return new Promise((resolve, reject) => {

            this.http.post(this.API, {
                email: email,
                password: password,
            })
                .subscribe(
                    res => {
                        if (res !== 0) {
                            this.isUserLoggedIn = true;
                            localStorage.setItem('auth_key', res['api']);
                            localStorage.setItem('login', res['login']);
                            resolve();
                        } else {
                            reject();
                            console.log(res);
                        }
                    },
                    err => {
                        console.log(err);
                        reject();

                    }
                );
        });
    }

    logged(key) {
        return new Promise((resolve, reject) => {

            this.http.post(this.API, {
                key: key
            })
                .subscribe(
                    res => {
                        if (res !== 0) {
                            this.isUserLoggedIn = true;
                            localStorage.setItem('auth_key', res['api']);
                            localStorage.setItem('login', res['login']);
                            resolve();
                        } else {
                            reject();
                            console.log(res);
                        }
                    },
                    err => {
                        console.log(err);
                        reject();

                    }
                );
        });
    }

    logOut() {
        this.isUserLoggedIn = false;
        localStorage.removeItem('email');
        localStorage.removeItem('auth_key');
        localStorage.removeItem('login');
    }

    isLoggedIn() {
        return this.isUserLoggedIn;
    }
}
