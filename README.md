## Requirements
- PHP:  ^8.0
- Laravel: ^8.38
- MySQL 
## Project setup

- `composer install`
- customize the `.env` file
- `php artisan key: generate`
_____________
### Database setup
1) create a database locally or on the server and specify it in the .env file(removed from .gitignore)
2) php artisan migrate
3) php artisan db:seed

_____________

## Launching the application

* php artisan serve

## Routes : 
<hr>
GET|HEAD | http://test/api/v1/users        | get all users
<hr>
POST     | http://test/api/v1/users        | Create User
<hr>
GET|HEAD | http://test/api/v1/users/{user} | Show one User by id 
<hr>
PUT|PATCH| http://test/api/v1/users/{user} | Update User by id 
<hr>
DELETE   | http://test/api/v1/users/{user} | Delete User
