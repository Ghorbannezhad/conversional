
## About Conversional

Conversional is a web application based on Laravel framework. 

This application is developed for invoice creation based on predifined accounting assumptions. 

## Installation

1. Install vendor:<br>
`$composer update`

2. Create database and set *.env* file 

3. Run migrations:<br>
`$php artisan migrate`

4. Seed database:<br>
`$php artisan db:seed`

##Usage
API documentation in ready based on [apidoc - npm library](https://www.npmjs.com/package/apidoc>)

`$apidoc -i app/Http/Controllers -o ../docs`



