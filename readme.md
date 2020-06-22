# Laravel Blog

A simple blog for demonstration purpose. Based on Laravel 7.0

## Requirements

- Laravel 7.0
- PHP >= 7.2.5
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension



## Demo login info

user: nilesh@gmail.com | password: password


## Installation

```
git clone https://github.com/techyniel/Article-Feed.git
cd Article-Feed
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

If you want dummy data, then run this-

```
php artisan db:seed --class=DummyDataSeeder
```

