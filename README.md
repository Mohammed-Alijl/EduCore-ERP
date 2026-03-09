# School System (Laravel 12)

A modern, scalable **School Management System** built with Laravel, designed to centralize school operations across three major areas:

- **Admin Dashboard** (currently implemented and active)
- **Teacher Dashboard** (planned / in progress)
- **Student Dashboard** (planned / in progress)
- **REST API Layer** (planned / in progress)

This project is structured for long-term growth, maintainability, and real-world production workflows.

---

## Table of Contents

- [Project Vision](#project-vision)
- [Current Development Status](#current-development-status)
- [Core Features](#core-features)
  - [Admin Dashboard](#admin-dashboard)
  - [Teacher Dashboard Roadmap](#teacher-dashboard-roadmap)
  - [Student Dashboard Roadmap](#student-dashboard-roadmap)
  - [API Roadmap](#api-roadmap)
- [Tech Stack](#tech-stack)
- [Architecture Highlights](#architecture-highlights)
- [Data Model Highlights](#data-model-highlights)
- [Localization & Security](#localization--security)
- [Getting Started](#getting-started)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [Run in Development](#run-in-development)
  - [Database Setup](#database-setup)
- [Suggested API Design Direction](#suggested-api-design-direction)
- [Quality, Testing & Tooling](#quality-testing--tooling)
- [Development Roadmap](#development-roadmap)
- [Contributing](#contributing)
- [License](#license)

---

## Project Vision

The goal of this system is to provide a **complete educational operations platform** where each stakeholder has a focused experience:

- **Administrators** manage structure, users, academics, attendance, and governance.
- **Teachers** manage teaching tasks, attendance, exams, and class engagement.
- **Students** access schedules, classes, exam performance, and personal academic data.
- **Integrations (API)** allow mobile apps, portals, or third-party systems to interact with the platform securely.

---

## Current Development Status

> ✅ **Implemented:** Admin dashboard + core academic domain models and workflows.
>
> 🛠️ **In progress / planned:** Teacher dashboard, Student dashboard, and production API endpoints.

The backend domain already includes rich entities (grades, classrooms, sections, teachers, students, guardians, subjects, attendances, exams, online classes, and more), which makes the next phases significantly faster to deliver.

---

## Core Features

### Admin Dashboard

Current admin capabilities include:

- Admin authentication, email verification, password reset, and profile management.
- Role & permission management.
- Academic structure setup:
  - Grades
  - Classrooms
  - Sections
  - Academic years
  - Subjects
- People management:
  - Admins
  - Teachers (with specializations and attachments)
  - Students
  - Guardians
- Operational workflows:
  - Student promotions
  - Attendance tracking
  - Exams and attempts monitoring
  - Online classes management
- Localization-aware routing and views.

### Teacher Dashboard Roadmap

Planned teacher portal scope:

- Personal dashboard (today classes, quick stats, pending tasks)
- Assigned classes and section overview
- Attendance submission and historical attendance views
- Exam management and grading workflows
- Online class scheduling and meeting links
- Teacher profile/settings

### Student Dashboard Roadmap

Planned student portal scope:

- Personal dashboard (attendance snapshot, upcoming classes/exams)
- Subject and classroom information
- Exam history and performance analytics
- Attendance history
- Online class links and schedule
- Profile and account settings

### API Roadmap

Planned API objectives:

- Authenticated endpoints for admin/teacher/student clients
- Token-based auth (Sanctum)
- Standardized response envelopes
- Pagination, filtering, and sorting for listing endpoints
- Role-aware authorization policies
- Versioned endpoint strategy (`/api/v1/...`)

---

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend tooling:** Vite, Tailwind CSS, Alpine.js
- **Database:** MySQL (default in `.env.example`)
- **Auth & Authorization:** Laravel auth + Spatie Permission + Sanctum (API middleware path already prepared)
- **Localization:** `mcamara/laravel-localization`
- **DataTables support:** `yajra/laravel-datatables`

---

## Architecture Highlights

This project follows a layered approach for cleaner growth:

- **Controllers** for HTTP orchestration
- **Services** for domain/business logic
- **Models + migrations** for data consistency
- **Policies/permissions** for access control
- **Localized route groups** for multilingual UX

This structure is ideal when introducing new dashboards (teacher/student) because domain logic can be reused with role-specific interfaces.

---

## Data Model Highlights

The schema already supports a comprehensive school domain:

- Users, Admins, Teachers, Students, Guardians
- Grades, Classrooms, Sections, Subjects, Specializations
- Academic Years, Enrollments, Teacher Assignments
- Attendance records
- Exams, Questions, Options, Attempts, and Results
- Online classes

---

## Localization & Security

- Locale-aware routing is enabled for multilingual support.
- Route-level throttling is applied for key flows.
- Separate guard and verification flow for admin authentication.
- Permissions and roles are integrated via Spatie package.

---

## Getting Started

### Requirements

- PHP 8.2+
- Composer
- Node.js 18+ and npm
- MySQL 8+ (or compatible)

### Installation

```bash
# 1) Clone repository
git clone <your-repo-url>
cd School-System

# 2) Install PHP dependencies
composer install

# 3) Install JS dependencies
npm install

# 4) Create environment file
cp .env.example .env

# 5) Generate app key
php artisan key:generate

# 6) Configure database credentials in .env, then run migrations
php artisan migrate
```

### Run in Development

```bash
# Start Laravel + queue + logs + Vite (combined)
composer run dev
```

Or run components separately:

```bash
php artisan serve
php artisan queue:listen --tries=1 --timeout=0
npm run dev
```

### Database Setup

In `.env`, update:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Then execute:

```bash
php artisan migrate
php artisan db:seed
```

---

## Suggested API Design Direction

When you begin API implementation, this structure will keep it professional and scalable:

- `routes/api.php` split by role/domain via route groups
- `App/Http/Controllers/Api/V1/...`
- API Resources for response shaping
- Form Requests for validation
- Policies + middleware for authorization
- Consistent JSON format:

```json
{
  "success": true,
  "message": "Fetched successfully",
  "data": {},
  "meta": {}
}
```

---

## Quality, Testing & Tooling

Recommended workflow:

```bash
# Run tests
php artisan test

# Optional style check (if configured by team)
./vendor/bin/pint
```

For dashboard expansion (teacher/student/API), prioritize:

- Feature tests per role
- Authorization tests for permissions
- API contract tests for critical endpoints

---

## Development Roadmap

- [x] Admin dashboard foundation and core school domain
- [ ] Teacher dashboard MVP
- [ ] Student dashboard MVP
- [ ] API v1 (auth + profile + attendance + exams)
- [ ] Notifications and messaging layer
- [ ] Production hardening (logs, monitoring, CI/CD)

---

## Contributing

Contributions are welcome. A suggested contribution flow:

1. Create a feature branch.
2. Keep commits small and descriptive.
3. Add/adjust tests where applicable.
4. Open a PR with clear context and screenshots for UI changes.

---

## License

This project is open-sourced under the **MIT License**.

---

If you want, I can also generate a second file (`README_API.md`) with a complete, production-grade API specification template (auth flow, endpoint matrix, error catalog, and versioning policy).
