
# Task Management System API
Cytonn Software Engineering Internship Challenge 2026

## Overview

This project is a Task Management System built using PHP Laravel (backend), Vue.js (frontend), and MySQL (database).

The system implements all required features and strictly enforces the provided business rules.

* Live version of the application: https://taskmaster-production-d24.up.railway.app/
* Source code: https://github.com/Ken-Mwirigi/TaskMaster

---

## Features

1. Create tasks with strict validation rules.
2. List tasks with automated sorting and status filtering.
3. Update task status with strict progression rules.
4. Delete tasks (restricted only to completed tasks).
5. Generate daily task reports (Bonus Feature).

---

## Technology Stack

* Backend: Laravel 11 (PHP 8.2)
* Frontend: Vue.js 3
* Database: MySQL
* Local Environment: XAMPP
* Deployment: Railway

---

## Database Structure

Table: tasks
* id (integer, primary key)
* title (string)
* due_date (date)
* priority (enum: low, medium, high)
* status (enum: pending, in_progress, done)
* created_at (timestamp)
* updated_at (timestamp)

---

## Business Rules Implemented

Create Task:
* Title must not duplicate another task with the same due_date.
* Priority must be one of: low, medium, high.
* Due date must be today or a future date.

List Tasks:
* Sorted by priority (high to low).
* Then sorted by due_date (ascending).
* Supports filtering by status.
* Returns a clear message if no tasks exist.

Update Task Status:
* Allowed transitions: pending -> in_progress -> done.
* Cannot skip or revert status.

Delete Task:
* Only tasks with status "done" can be deleted.
* Otherwise returns 403 Forbidden.

Daily Report:
* Returns counts grouped by priority and status for a given date.

---

## Local Setup Instructions (XAMPP)

### Requirements
* XAMPP (MySQL)
* PHP 8.2 or higher
* Composer
* Node.js and npm

### Step 1: Setup Database
1. Open XAMPP Control Panel.
2. Start MySQL.
3. Open phpMyAdmin (http://localhost/phpmyadmin).
4. Create a database named: `task_manager_db`

### Step 2: Install Project Dependencies
Open your terminal in the project folder and run:
```bash
composer install
npm install
```

### Step 3: Configure Environment
Copy the environment file:
```bash
cp .env.example .env
```
Generate the app key:
```bash
php artisan key:generate
```
Edit your `.env` file to match your XAMPP database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager_db
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Run Migrations
Run the migrations to build the tables:
```bash
php artisan migrate
```
*(Optional: If you prefer using the dump file, you can import `task_manager_db.sql` directly into phpMyAdmin instead).*

### Step 5: Start Application
Build the frontend assets:
```bash
npm run build
```
Start the backend server:
```bash
php artisan serve
```
Open your browser and navigate to: http://localhost:8000

---

## API Endpoints

* POST /api/tasks (Create a task)
* GET /api/tasks (List all tasks. Optional: ?status=pending)
* PATCH /api/tasks/{id}/status (Update task status)
* DELETE /api/tasks/{id} (Delete task, only if done)
* GET /api/tasks/report?date=YYYY-MM-DD (Get daily report)

---

## Example Requests

Create Task (POST /api/tasks)
```json
{
  "title": "Finish assignment",
  "due_date": "2026-04-02",
  "priority": "high"
}
```

Update Status (PATCH /api/tasks/1/status)
```json
{
  "status": "in_progress"
}
```

---

## Testing Instructions

Important: Always include this header in your API requests:
`Accept: application/json`

### Automated Tests
To run the automated test suite, execute the following command in your terminal:
```bash
php artisan test
```
### Manual Tests
Test the following cases to verify business logic:
1. Create task with valid data -> should succeed.
2. Create duplicate title with same date -> should fail (422).
3. Create task with past date -> should fail.
4. Create task with invalid priority -> should fail.
5. List tasks -> should return sorted results.
6. Filter tasks by status -> should return correct results.
7. Update status correctly -> should succeed.
8. Skip status (pending -> done) -> should fail.
9. Delete non-done task -> should return 403.
10. Delete done task -> should succeed.
11. Get report -> should return correct summary.

---

## Deployment Instructions

This project is deployed on Railway using a provisioned MySQL database.

Steps taken for deployment:
1. Create a Railway project.
2. Add a MySQL database instance.
3. Connect the GitHub repository.
4. Set the environment variables in the Railway Variables tab.
5. Run the deployment and execute migrations via the Custom console:
   `php artisan migrate --force`

---

## Submission Details

* Full project source code included.
* MySQL dump file (`task_manager_db.sql`) included in the root directory.
* README included with setup and testing instructions.
* Application hosted online.

Submission email: support@cytonn.com
Subject: Software Engineering Internship - Coding Challenge 2026

---

## Author
Kennedy Kamau
```