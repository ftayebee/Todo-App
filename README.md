# Todo API (Laravel Sanctum)

This is a simple Todo API built with Laravel 12 using Sanctum for authentication.

## Features

- User registration, login, and logout  
- CRUD operations on tasks  
- Authenticated access using Laravel Sanctum  
- Error handling and validation  
- Automated API tests  

---

## Authentication

This API uses **Laravel Sanctum** for token-based authentication.

**Test Username:** `trtayebee089@gmail.com`  
**Test Password:** `17354583089`

---

## Live URLs

- **Frontend:** [https://ftodo-app.netlify.app/](https://ftodo-app.netlify.app/)
- **API Base URL:** `https://todo-app.fahimtayebee.com/api/`

---

## API Endpoints

### Auth Routes

| Method | Endpoint                                                        | Description         | Auth Required |
|--------|------------------------------------------------------------------|---------------------|----------------|
| POST   | `https://todo-app.fahimtayebee.com/api/register`                | Register a new user | ❌              |
| POST   | `https://todo-app.fahimtayebee.com/api/login`                   | Login and get token | ❌              |
| POST   | `https://todo-app.fahimtayebee.com/api/logout`                  | Logout user         | ✅ (token)      |

### Task Routes (Protected)

All task endpoints require Sanctum token authentication.

| Method | Endpoint                                                                   | Description             |
|--------|----------------------------------------------------------------------------|-------------------------|
| GET    | `https://todo-app.fahimtayebee.com/api/tasks`                              | List all tasks          |
| POST   | `https://todo-app.fahimtayebee.com/api/tasks/store`                        | Create a new task       |
| POST   | `https://todo-app.fahimtayebee.com/api/tasks/update/{id}`                 | Update an existing task |
| POST   | `https://todo-app.fahimtayebee.com/api/tasks/destroy/{id}`                | Delete a task           |

---

## Running Tests

You can find feature tests under:

- `tests/Feature/AuthApiTest.php`
- `tests/Feature/TaskApiTest.php`

---

## Project Structure

- `app/Http/Controllers/AuthController.php` – Auth logic  
- `app/Http/Controllers/TaskController.php` – Task CRUD logic  
- `routes/api.php` – API Routes  
- `tests/Feature/` – Feature tests for endpoints