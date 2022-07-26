# SPA with Vue Cli and Laravel and JWT Token Based Application
## Requirements

- Laravel 9
- nodejs 12.14
- PHP >= 8.0
- MySQL >= 5.7
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension

## Installation
Open Terminal and Clone the repository
```
$ git clone https://github.com/rajibdas222/Tmss_test.git
```
### Backend Configuration
```
$ cd backend
$ composer install
$ cp .env.example .env
```
Set value on the following environment variable
- APP_KEY
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD
- JWT_SECRET
- JWT_TTL
- AUTH_COOKIE_NAME
```
$ php artisan migrate --seed
$ php -S localhost:8000 -t public
```
Now your API host is running on http://localhost:8000/

### Frontend Configuration
```
$ cd ..
$ cd frontend
$ npm install
$ npm run serve
```
Now your frontend is running on http://localhost:8080/

## Default Credentials
- Username : admin@gmail.com or user1@gmail.com
- Password : 12345678

