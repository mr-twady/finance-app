# Finance App Trial Project

This project proposal has been put together to help developers who are applying for new positions but don't have any sample code to provide during the hiring process.

## Installation Guide

- Create a `.env` file, copy the content in `.env.example` and paste into the new `.env` file. Appropriately fill up the environment variables according to your system configuration. 
- Run `composer install`
- Run `php artisan key:generate`
- Run `php artisan migrate`
- Run `php artisan db:seed`
- Run `npm install` and `npm run production` (if moving to production)
- Clear cache or run `php artisan config:clear`(if you modified environment variables file)
- Run` php artisan serve`
