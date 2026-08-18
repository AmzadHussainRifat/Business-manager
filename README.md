# Hybrid Business Management System (HBMS)

A web-based business management platform for small retail businesses — inventory, sales, customers, and expenses in one system.

## Tech Stack

Laravel 13, PHP 8.4, MySQL, Blade, Tailwind CSS, Alpine.js

## Setup

composer install
npm install
cp .env.example .env
php artisan key:generate

Set your database details in .env, then create the database in MySQL and run:

php artisan migrate
php artisan db:seed --class=DemoDataSeeder
php artisan storage:link

Run these two in separate terminals, both left running:

php artisan serve
npm run dev

Visit http://127.0.0.1:8000.

## Login

Admin: admin@example.com / password123

Staff (PIN login): Sam Carter — 123456, Priya Shah — 111111, Jordan Lee — 222222

If no seeder has been run, the login page will redirect to a registration form to create the first admin account.

## Features

- Role-based access for staff and admin
- FIFO inventory costing
- Overselling handled as resolvable debt instead of blocked
- Customers linked automatically to sales
- Product deletion preserves sales history
- Expense categories and receipt uploads
- Reports across daily, weekly, monthly, and yearly periods
