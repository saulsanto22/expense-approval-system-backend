# Expense Approval System

## System Requirements
- PHP 8.4
- Laravel 12
- MySQL 5.7+

## Installation
1. extrak projek
2. Run `composer install` dan `composer update`
3. Copy `.env.example` to `.env`
4. Configure database in `.env`
5. Run migrations: `php artisan migrate`
6. Seed initial data: `php artisan db:seed`
7. Generate Swagger docs: `php artisan l5-swagger:generate`


## Running the Application
Start development server:
php artisan serve

NOTE:
-Jika ingin mencoba melalui Swagger UI, akses ke : http://127.0.0.1:8000/api/documentation (Tergatung Local masing masing)
-jika ingin mencoba melalui PHPUnit, ketik perintah php artisan test

