# Laravel Multi-Tenant Task Management API

## 📌 Overview

This project is a **Multi-Tenant Task Management REST API** built with Laravel. Multiple companies (tenants) share the same application while maintaining **strict data isolation**. Each tenant has its own users and tasks, and no tenant can access another tenant’s data.

---

# 🚀 Setup Instructions

## 1️⃣ Clone Repository

```bash
git clone https://github.com/your-username/task-management-api.git
cd task-management-api
```

## 2️⃣ Install Dependencies

```bash
composer install
```

## 3️⃣ Environment Configuration

Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

Update database credentials in `.env`:

```env
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=
```

## 4️⃣ Generate App Key

```bash
php artisan key:generate
```

## 5️⃣ Run Migrations & Seeders

```bash
php artisan migrate --seed
```

## 6️⃣ Start Server

```bash
php artisan serve
```

API will be available at:

```
http://127.0.0.1:8000
```

---

# 🗄️ Database Schema Explanation

## Tenants Table

| Column       | Type            | Description       |
| ------------ | --------------- | ----------------- |
| id           | bigint          | Tenant ID         |
| company_name | string          | Company name      |
| subdomain    | string (unique) | Tenant identifier |
| created_at   | timestamp       |                   |

## Users Table

| Column    | Type                | Description      |
| --------- | ------------------- | ---------------- |
| id        | bigint              | User ID          |
| name      | string              | User name        |
| email     | string (unique)     | Login email      |
| password  | string              | Hashed password  |
| tenant_id | foreign key         | Tenant ownership |
| role      | enum(admin, member) | Role             |

## Tasks Table

| Column      | Type                                  | Description      |
| ----------- | ------------------------------------- | ---------------- |
| id          | bigint                                | Task ID          |
| title       | string                                | Task title       |
| description | text                                  | Optional         |
| status      | enum(pending, in_progress, completed) | Task status      |
| tenant_id   | foreign key                           | Tenant ownership |
| created_by  | foreign key                           | Creator user     |
| assigned_to | foreign key                           | Assigned user    |
| due_date    | date                                  | Optional         |

---

# 🏢 Multi-Tenancy Approach

## Tenant Identification

Tenant is resolved using:

-   HTTP Header: `X-Tenant-ID`

## Isolation Levels Implemented

✅ Middleware (TenantResolver)
✅ Query filtering (`where tenant_id = ...`)
✅ Model Policies (Authorization Layer)
✅ Feature Tests

This ensures **no cross-tenant data leakage**.

---

# 🔐 Authentication & Authorization

## Authentication

-   Laravel Sanctum token-based authentication

## Roles

| Role   | Permissions                  |
| ------ | ---------------------------- |
| Admin  | Manage users, view all tasks |
| Member | View only own tasks          |

Policies enforce RBAC and tenant isolation.

---

# 📡 API Documentation

## 🔹 Tenant Registration

```http
POST /api/tenants
```

### Request

```json
{
    "company_name": "Acme Corp",
    "subdomain": "acme",
    "admin_email": "admin@acme.com",
    "admin_password": "Password123!"
}
```

---

## 🔹 Login

```http
POST /api/login
```

### Request

```json
{
    "email": "admin@acme.com",
    "password": "Password123!"
}
```

---

## 🔹 Create User (Admin Only)

```http
POST /api/users
Header: X-Tenant-ID: acme
Authorization: Bearer TOKEN
```

```json
{
    "name": "John",
    "email": "john@acme.com",
    "password": "secret123",
    "role": "member"
}
```

---

## 🔹 Task CRUD

### Create Task

```http
POST /api/tasks
```

```json
{
    "title": "Finish Report",
    "description": "Quarterly report",
    "assigned_to": 2,
    "status": "pending",
    "due_date": "2026-02-20"
}
```

### List Tasks (with filters)

```http
GET /api/tasks?status=pending&assigned_to=2&from=2026-02-01&to=2026-02-28
```

### Update Task

```http
PUT /api/tasks/{id}
```

### Delete Task

```http
DELETE /api/tasks/{id}
```

---

# 🧪 Testing

## Run Tests

```bash
php artisan test
```

## Implemented Test Cases

-   Tenant isolation (Tenant A cannot read Tenant B data)
-   Admin can view all tenant tasks
-   Member cannot view other users’ tasks
-   Cross-tenant task assignment prevented

---

# 🧾 Example Tenant Isolation Test Request

### Tenant A tries to access Tenant B task

```http
GET /api/tasks/10
X-Tenant-ID: tenant-a
Authorization: Bearer TOKEN_A
```

### Response

```http
403 Forbidden
```

---

# 📦 Deliverables

✔ Complete Laravel source code
✔ Migrations & Seeders
✔ Feature tests
✔ API Documentation
✔ Multi-tenancy explanation

---

# 🧠 Architectural Notes

-   Tenant isolation enforced at **middleware, policy, and query level**
-   RBAC implemented via Laravel Policies
-   RESTful API structure
-   Secure password hashing and validation

---

# ✅ Author

**Youssef Ashraf**
