# Knowledge Hub

Knowledge Hub is a Laravel library management system with two roles:

- Administrator: manages books, categories, customers, borrowing requests, reports, inventory, and dashboard analytics.
- Customer: registers, logs in, views available books, requests books, and tracks only their own borrowing records.

The project supports both SQLite and MySQL. SQLite is the recommended quick setup for teachers, clients, demos, and testing because it does not require a database server.

## Requirements

- PHP 8.2 or newer
- Composer
- Node.js and npm
- SQLite PHP extension enabled
- MySQL or MariaDB only if you want to use the MySQL setup

## SQLite Quick Setup

Use this path when you want to run the project without installing MySQL.

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

Open the app:

```text
http://127.0.0.1:8000
```

The default `.env.example` is already configured for SQLite:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

The SQLite database file is included at:

```text
database/database.sqlite
```

If it is ever deleted, recreate it before running migrations:

```bash
touch database/database.sqlite
php artisan migrate --seed
```

On Windows PowerShell:

```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
php artisan migrate --seed
```

## MySQL Setup

Use MySQL when you want a traditional local development database.

1. Create a MySQL database, for example:

```sql
CREATE DATABASE library_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_db
DB_USERNAME=root
DB_PASSWORD=
```

3. Run setup:

```bash
composer install
npm install
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

## Default Login Credentials

Administrators are created by seeders and should not register through the website.

```text
Admin 1
Email: admin@library.test
Password: password
```

```text
Admin 2
Email: admin2@library.test
Password: password
```

Demo customer:

```text
Email: customer@library.test
Password: password
```

Customers can also register from the login page. After registration, they are redirected back to login and must sign in with their credentials.

## Useful Commands

Run migrations and seed demo data:

```bash
php artisan migrate --seed
```

Reset the database and seed again:

```bash
php artisan migrate:fresh --seed
```

Run tests:

```bash
php artisan test
```

Build frontend assets:

```bash
npm run build
```

Start the Laravel development server:

```bash
php artisan serve
```

## What Is Not Included

This repository should not depend on or commit:

- `vendor/`
- `node_modules/`
- personal `.env` files
- generated frontend build files in `public/build/`

Install dependencies locally with Composer and npm after cloning.
