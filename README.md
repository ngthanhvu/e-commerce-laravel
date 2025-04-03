### PHP3 LARAVEL 
```bash
composer install
```
### Chuyển .env.example thành .env
```bash
copy .env.example .env
```
### Tạo database
```bash
php artisan migrate
```
### Tạo app_key
```bash
php artisan key:generate
```
### Chạy dự án laravel
```bash
php artisan serve
```
### Public thư mục storage
```bash
php artisan storage:link
```
### Thư viện login social
```bash
composer require laravel/socialite
```
### Thư viện Guzzle Http Client
```bash
composer require guzzlehttp/guzzle
```