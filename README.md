# E-Procurement API System

## Tech tools
- **Framework**: Laravel 10+
- **Language**: PHP 8.1+
- **Database**: MySQL
- **Authentication**: Laravel Sanctum

## How to Setup
1. Clone the repo:
  ```
  git clone https://github.com/vickyfebiola/e-procurement.git
  ```
3. Install dependecies
  ```
  composer install
  ```
5. Copy .env and generate app key:
  ```
  cp .env.example .env
  ```
  ```
  php artisan key:generate
  ```
4. Set up database in .env and run migrations:
  ```
  php artisan migrate
  ```
5. Install Laravel Sanctum (optional):
  ```
  php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
  ```
6. Run the server
  ```
  php artisan serve
  ```

## Features
### User
- Register/Create a new user
  ```http
  POST /api/register
  ```
- Login and receive a Bearer token.
  ```
  POST /api/login
  ```
### Vendor
- Create new vendors  
  ```http
  POST /api/vendors
  ```
### Product
- List products  
  ```http
  GET /api/products
  ```
- Create new products  
  ```http
  POST /api/products
  ```
- View/Show product  
  ```http
  GET /api/products/{id}
  ```
- Update products  
  ```http
  PUT /api/products/{id}
  ```
- Delete products (single)  
  ```http
  DELETE /api/products/{id}
  ```
- Delete products (bulk)  
  ```http
  DELETE /api/products/delete-products
  ```
