# User Management System

A Laravel-based user management application for handling members, authentication, account setup, and presentation-friendly admin workflows.

## Overview

This project is built with:

- Laravel 13
- PHP
- Bootstrap UI components
- SQLite for local development fallback
- Docker Compose for containerized development and deployment support

The application provides a simple member management experience with:

- user authentication and registration
- member CRUD operations
- dashboard summary view
- CSV export for members
- admin-style presentation flow for demos

## Tech Stack

### Backend
- Laravel Framework
- Eloquent ORM
- Artisan CLI

### Frontend
- Blade templates
- Bootstrap 5
- Tailwind-based welcome page assets

### Containerization
- Dockerfile
- docker-compose.yml
- Nginx service configuration for the app container

## Project Structure

- `app/` — application logic, controllers, models, and providers
- `resources/views/` — Blade templates for the dashboard, members, and authentication views
- `routes/` — web and auth routes
- `database/` — migrations, seeders, and factories
- `docker/` — Nginx configuration for Docker-based deployment

## Local Development

### Option 1: Laravel built-in server

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

### Option 2: Docker Compose

```bash
docker-compose up --build
```

This repository includes Docker configuration intended for containerized execution, including an Nginx web service and app container setup.

## Demo Notes

The system is structured for a clean presentation/demo flow:

- welcome page for first-time users
- create account flow
- login and password recovery path
- dashboard overview
- member search and export actions

## Useful Commands

```bash
php artisan test
php artisan migrate
php artisan serve
php artisan route:list
```

## License

This project is intended for demo and development use. If you are publishing it publicly, you may want to add your preferred license file, such as MIT.
