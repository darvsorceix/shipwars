import {Injectable} from '@angular/core';
import {Router, CanLoad, Route} from '@angular/router';
import {Observable} from 'rxjs/Observable';
import {AuthService} from './auth.service';

@Injectable()
export class AuthGuard implements CanLoad {

    constructor(private authService: AuthService, private router: Router) {
    }

    private authKey = '';

    canLoad(route: Route): Observable<boolean> | Promise<boolean> | boolean {
        this.authKey = localStorage.getItem('auth_key');
        if (this.authService.isLoggedIn()) {
            return true;
        } else if (this.authKey !== null) {
            return true;
        }
        this.router.navigate(['/login']);
        return false;
    }
}
