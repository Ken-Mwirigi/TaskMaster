You are absolutely right. If a recruiter is reviewing dozens of applications today, we want yours to be the most foolproof, explicitly clear, and easy-to-read document they open. 

Since you used XAMPP for your local database, I have completely rewritten the Local Setup section to specifically walk them through using XAMPP. I have also simplified the language so it is incredibly easy to scan. 

Here is your final, 100% copy-and-paste ready `README.md`. Just remember to swap out the `[INSERT_YOUR_GITHUB_LINK_HERE]` placeholder at the top!

***

```markdown
# Cytonn Software Engineering Internship - TaskMaster API

A full-stack Task Management platform built for the 2026 Cytonn Software Engineering Internship Challenge. This application strictly enforces all provided business rules using a Laravel 11 backend API and a responsive Vue.js 3 (Composition API) frontend.

### 🚀 Quick Links
* **Live Demo:** https://taskmaster-production-d24.up.railway.app/
* **GitHub Repository:** https://github.com/Ken-Mwirigi/TaskMaster.git

---

## 🛠 Tech Stack
* **Backend:** PHP / Laravel 11
* **Frontend:** JavaScript / Vue.js 3 / Tailwind CSS
* **Database:** MySQL
* **Hosting:** Railway.app

---

## 📦 What is Included in this Zip File?
1. The complete **source code** for the application.
2. The **MySQL Dump File** (`task_manager.sql`) as requested in the instructions.
3. This **README** documentation.

---

## ✨ Features & Business Rules Achieved

1. **Task Creation:** Validates priority (`low`, `medium`, `high`) and ensures the `due_date` is today or in the future. Prevents duplicate task titles on the exact same date.
2. **Task Listing:** Automatically sorts tasks by Priority (High → Medium → Low), and then by Due Date (Ascending). Includes a `?status=` filter.
3. **Strict Status Updates:** Enforces a strict, one-way progression (`pending` → `in_progress` → `done`). Attempting to skip or reverse a status returns a `422 Unprocessable Entity` error.
4. **Protected Deletion:** Only tasks marked as `done` can be deleted. Attempting to delete an active task returns a `403 Forbidden` error.
5. **Bonus Feature (Daily Report):** A custom endpoint that returns the total count of tasks grouped by their priority and status for any specific date.

---

## 💻 Local Setup Instructions (Using XAMPP)

Follow these exact steps to run this project locally on your machine.

### Prerequisites
Make sure you have the following installed:
* **XAMPP** (For MySQL)
* **PHP >= 8.2**
* **Composer**
* **Node.js & NPM**

### Step 1: Database Setup via XAMPP
1. Open the **XAMPP Control Panel**.
2. Start the **MySQL** module.
3. Open your browser and go to `http://localhost/phpmyadmin`.
4. Create a brand new, empty database and name it: `task_manager`
5. *(Optional)* You can either import the provided `task_manager.sql` dump file here, OR use the Laravel migrations in Step 4.

### Step 2: Extract & Install Dependencies
1. Extract this project folder and open it in your terminal/command prompt.
2. Install the PHP backend dependencies:
   ```bash
   composer install
   ```
3. Install the JavaScript frontend dependencies:
   ```bash
   npm install
   ```

### Step 3: Environment Setup
1. Duplicate the `.env.example` file and rename the copy to `.env`.
2. Generate the application key:
   ```bash
   php artisan key:generate
   ```
3. Open the `.env` file and ensure your database credentials match XAMPP's defaults:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task_manager
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### Step 4: Run Migrations & Seed Data
*(If you did not import the SQL dump file manually, run this command to build the tables and insert test data):*
```bash
php artisan migrate --seed
```

### Step 5: Start the Application
To run both the backend and frontend, you need to run these two commands. 

1. Build the Vue.js frontend files:
   ```bash
   npm run build
   ```
2. Start the Laravel backend server:
   ```bash
   php artisan serve
   ```
3. Open your browser and visit: `http://localhost:8000`

---

## 📡 API Documentation & Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/api/tasks` | Create a new task. |
| `GET`  | `/api/tasks` | List all tasks (Supports `?status=pending` filtering). |
| `PATCH`| `/api/tasks/{id}/status` | Progress a task's status forward. |
| `DELETE`| `/api/tasks/{id}` | Delete a task (Only if status is 'done'). |
| `GET`  | `/api/tasks/report?date=YYYY-MM-DD` | Get the Bonus Daily Analytics Report. |

**Example POST Request (Create Task):**
```json
{
  "title": "Evaluate application",
  "due_date": "2026-04-05",
  "priority": "high"
}
```
```

***
