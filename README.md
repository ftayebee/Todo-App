# Todo API (Laravel Sanctum)

This is a simple Todo API built with Laravel 12 using Sanctum for authentication.

## Features

- User registration, login, and logout
- CRUD operations on tasks
- Authenticated access using Laravel Sanctum
- Error handling and validation
- Automated API test

---

## Authentication

This API uses **Laravel Sanctum** for token-based authentication.

= Test Username: fahim.tayebee@gmail.com
= Test password: 12345678

---

## API Endpoints

### Auth Routes

| Method | Endpoint        | Description         | Auth Required |
| ------ | --------------- | ------------------- | ------------- |
| POST   | `/api/register` | Register a new user | ❌             |
| POST   | `/api/login`    | Login and get token | ❌             |
| POST   | `/api/logout`   | Logout user         | ✅ (token)     |

### Task Routes (Protected)

All task endpoints require Sanctum token authentication.

| Method | Endpoint                  | Description             |
| ------ | ------------------------- | ----------------------- |
| GET    | `/api/tasks`              | List all tasks          |
| POST   | `/api/tasks/store`        | Create a new task       |
| POST   | `/api/tasks/update/{id}`  | Update an existing task |
| POST   | `/api/tasks/destroy/{id}` | Delete a task           |

## Running Tests

You can find feature tests under `tests/Feature/AuthApiTest.php` and `tests/Feature/TaskApiTest.php`.

---

## Project Structure

* `app/Http/Controllers/AuthController.php` – Auth logic
* `app/Http/Controllers/TaskController.php` – Task CRUD logic
* `routes/api.php` – API Routes
* `tests/Feature/` – Feature tests for endpoints

---