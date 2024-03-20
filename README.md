# Book Exchange API

API for a Book Exchanging community.

## Installation

1. Clone the repository.
2. Run `composer install` to install the dependencies.
3. Create a `.env` file by copying the `.env.example` file and updating the database and mailing credentials.
4. Run `nvm use` to use the correct Node.js version.
5. Run `npm install` to install the dependencies.
6. Run `npm run dev` to compile the assets.
7. Run `php artisan key:generate` to generate the application key.
8. Run `php artisan storage:link` to create a symbolic link to the storage directory.
9. Run `php artisan migrate` to run the migrations.
10. Run `php artisan db:seed` to seed the database with the default data.
11. Run `php artisan serve` to start the server.
12. In another terminal, run `php artisan queue:listen` to start the queue listener.

## Features

- User registration.
- Admin dashboard.

## Admin Dashboard

Visit `/admin` to access the admin dashboard. The default credentials are:

- Email: `john.doe@book-exchange.com`
- Password: `12345678`

## API Documentation

The API documentation is available at `/docs/api`.
