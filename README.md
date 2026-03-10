
# 🎓 EduCore ERP & LMS

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

EduCore is a modern, enterprise-grade School Enterprise Resource Planning (ERP) and Learning Management System (LMS) built with Laravel. Designed with a focus on **Clean Architecture, SOLID principles, and Service-Oriented design patterns**, this system provides a comprehensive solution for managing educational institutions.

## 🚀 Project Vision
The goal of this project is to create a seamless, frictionless educational ecosystem with dedicated dashboards for Admins, Teachers, and Students, topped with a fully documented RESTful API for mobile and third-party integrations.

## 🏗️ Architecture & Backend Highlights
This is not a standard CRUD application. It features complex business logic and advanced database relationship handling:

* **Dynamic Random Exam Engine:** A custom-built exam module where questions are pulled randomly from a central Question Bank, securely locked to a student's session to survive internet disconnections and prevent cheating.
* **Disaster Recovery (Admin Override):** Built-in fail-safes allowing administrators to gracefully reset stuck exam attempts and manage exceptions.
* **Smart Virtual Classrooms:** Dual-integration logic supporting both automated Zoom API meetings and manual external links (Google Meet/Teams) seamlessly.
* **Skinny Controllers & Service Pattern:** Heavy business logic is decoupled into dedicated Service classes, ensuring controllers remain clean and strictly handle HTTP requests.
* **Strict Data Integrity:** Custom FormRequests, validation rules, and localized middleware constraints prevent dirty data and secure all administrative endpoints.
* **Role-Based Access Control (RBAC):** Powered by Spatie Permission Package with granular permission management.

## ✨ Features Overview

### 🔐 Authentication & Security (Completed ✅)
- [x] User Registration & Login
- [x] Email Verification
- [x] Password Reset & Forgot Password
- [x] Multi-Role Authentication (Admin, Teacher, Student, Guardian)
- [x] Role-Based Access Control (RBAC) with Spatie Permissions
- [x] Session Management & Security
- [x] Profile Management with Image Upload

### 🛡️ Admin Dashboard (Completed ✅)

#### 📊 Dashboard & Overview
- [x] Comprehensive Dashboard with Statistics
- [x] Real-time Analytics & Insights
- [x] Quick Access Navigation

#### 🏫 Academic Structure Management
- [x] **Academic Years Management**
  - Create, Edit, Delete Academic Years
  - Set Active Academic Year
  - Year-based Data Filtering
  
- [x] **Grades Management**
  - Multi-level Grade System
  - Grade Configuration & Settings
  - Grade-wise Student Organization
  
- [x] **Classrooms Management**
  - Classroom Creation & Assignment
  - Capacity Management
  - Grade-based Classification
  
- [x] **Sections Management**
  - Section Creation within Classrooms
  - Student Distribution across Sections
  - Teacher Assignment to Sections

#### 👥 Users Management
- [x] **Teachers Management**
  - Teacher Registration & Profile Management
  - Specialization Assignment
  - Teacher Performance Tracking
  - Document Management (CV, Certifications)
  
- [x] **Teacher Assignments**
  - Subject-to-Teacher Mapping
  - Section-wise Teacher Allocation
  - Workload Distribution
  
- [x] **Specializations**
  - Subject Specialization Categories
  - Teacher Expertise Mapping
  
- [x] **Students Management**
  - Student Registration & Enrollment
  - Student Profile Management
  - Academic Record Tracking
  - Guardian Linking
  - Bulk Import/Export
  
- [x] **Student Promotions**
  - Academic Year Promotion System
  - Grade-to-Grade Advancement
  - Bulk Promotion Tools
  - Promotion History Tracking
  
- [x] **Student Graduations** (Partially Complete ⏳)
  - Graduation Processing
  - Certificate Generation
  
- [x] **Guardians Management**
  - Guardian Registration & Profiles
  - Student-Guardian Relationship Management
  - Multiple Students per Guardian Support
  - Contact Management
  
- [x] **Admins Management**
  - Admin User Creation
  - Administrative Access Control
  - Admin Activity Logs
  
- [x] **Roles & Permissions**
  - Custom Role Creation
  - Granular Permission Assignment
  - Permission Groups Management
  - Role-based Dashboard Access

#### 📚 Learning Management System (LMS)
- [x] **Attendance Management**
  - Daily Attendance Recording
  - Section-wise Attendance Tracking
  - Attendance Reports & Analytics
  - Absence Notifications
  
- [x] **Subjects Management**
  - Subject Creation & Configuration
  - Grade-wise Subject Assignment
  - Subject Prerequisites
  
- [x] **Exams System**
  - Exam Creation & Scheduling
  - Random Question Selection from Question Bank
  - Session-locked Exam Security
  - Auto-grading System
  - Manual Grading Interface
  - Exam Global Monitoring Dashboard
  - Disaster Recovery for Stuck Attempts
  - Multiple Attempt Management
  - Grade Calculation & Publishing
  
- [x] **Online Classes (Virtual Classrooms)**
  - Zoom API Integration for Auto-meeting Creation
  - Manual Meeting Link Support (Google Meet, MS Teams)
  - Class Scheduling
  - Student Join Tracking
  - Recording Management
  - Class Attendance Integration

- [ ] **Library Management** (Upcoming 🔜)
  - Book Inventory
  - Issue/Return System
  - Digital Resources

#### 💰 Accounts & Financial Management (In Progress ⏳)
- [ ] **Fees Management**
  - Fee Structure Configuration
  - Student Fee Assignment
  - Payment Tracking
  
- [ ] **Invoices**
  - Invoice Generation
  - Payment History
  
- [ ] **Receipts**
  - Receipt Generation
  - Payment Confirmation
  
- [ ] **Payment Processing**
  - Online Payment Integration
  - Payment Gateway Support

#### 📈 Reports & Settings
- [ ] **Reports** (Planned 📋)
  - Attendance Reports
  - Financial Reports
  - Academic Performance Reports
  - Custom Report Builder
  
- [ ] **Activity Logs** (Planned 📋)
  - User Activity Tracking
  - System Audit Trail
  
- [ ] **System Settings** (Planned 📋)
  - General Settings
  - Email Configuration
  - Notification Settings

### 👨‍🏫 Teacher Dashboard (In Development ⏳)
- [ ] Personal Dashboard & Analytics
- [ ] Centralized Question Bank Management
- [ ] Custom Exam Creation
  - Maximum Attempts Configuration
  - Grading Methods (Auto/Manual)
  - Time Windows & Deadlines
- [ ] Student Evaluation & Grading Interface
- [ ] Attendance Management
- [ ] Class Schedule Management
- [ ] Zoom Integration for One-click Virtual Classes
- [ ] Assignment Creation & Management
- [ ] Student Progress Tracking

### 👨‍🎓 Student Dashboard (Upcoming 📋)
- [ ] Personal Dashboard
- [ ] Smart Exam-taking Interface
  - Session Persistence
  - Auto-save Functionality
  - Time Management
- [ ] Virtual Class Access
  - Dynamic Schedule Display
  - One-click Join Buttons
  - Class Materials Access
- [ ] Automated Grading & Results
- [ ] Assignment Submission
- [ ] Attendance Records
- [ ] Academic Performance Analytics

### 📱 RESTful API (Upcoming 📋)
- [ ] JWT Authentication
- [ ] Mobile-ready Endpoints
- [ ] Student & Parent Access
- [ ] Real-time Notifications
- [ ] API Documentation (Swagger/Postman)

## 💻 Tech Stack

**Backend:**
- Laravel 11
- PHP 8.2
- MySQL Database

**Frontend:**
- Blade Template Engine
- Bootstrap 4/5 (Valex Admin Theme)
- jQuery
- DataTables.js
- SweetAlert2
- Chart.js

**Packages & Libraries:**
- Spatie Laravel Permission (RBAC)
- Laravel Sanctum (API Authentication - Planned)
- Intervention Image (Image Processing)
- Maatwebsite Excel (Import/Export)
- Zoom API SDK

## ⚙️ Installation (Local Development)

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL >= 5.7
- Node.js & NPM

### Installation Steps

```bash
# 1. Clone the repository
git clone https://github.com/Mohammed-Alijl/EduCore-ERP.git
cd EduCore-ERP

# 2. Install PHP Dependencies
composer install

# 3. Install Node Dependencies
npm install

# 4. Environment Setup
cp .env.example .env
php artisan key:generate

# 5. Configure Database
# Edit .env file and set your database credentials:
# DB_DATABASE=your_database_name
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# 6. Run Migrations & Seeders
php artisan migrate --seed

# 7. Create Storage Link
php artisan storage:link

# 8. Compile Frontend Assets
npm run dev
# For production:
# npm run build

# 9. Serve the Application
php artisan serve
```

The application will be available at `http://localhost:8000`

### Default Login Credentials
After seeding, you can login with:
- **Admin:** admin@educore.com / password
- **Teacher:** teacher@educore.com / password
- **Student:** student@educore.com / password

## 📂 Project Structure

```
EduCore-ERP/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Admin/          # Admin Dashboard Controllers
│   │   ├── Requests/           # Form Request Validation
│   │   └── Middleware/         # Custom Middleware
│   ├── Models/                 # Eloquent Models
│   ├── Services/               # Business Logic Services
│   └── Repositories/           # Data Access Layer
├── database/
│   ├── migrations/             # Database Migrations
│   ├── seeders/                # Database Seeders
│   └── factories/              # Model Factories
├── resources/
│   ├── views/
│   │   ├── admin/              # Admin Views
│   │   ├── teacher/            # Teacher Views (Coming Soon)
│   │   └── student/            # Student Views (Coming Soon)
│   └── lang/                   # Localization Files
└── routes/
    ├── web.php                 # Web Routes
    └── api.php                 # API Routes (Coming Soon)
```

## 🔒 Security Features

- **CSRF Protection** on all forms
- **SQL Injection Prevention** via Eloquent ORM
- **XSS Protection** via Blade templating
- **Password Hashing** using bcrypt
- **Email Verification** for new accounts
- **Rate Limiting** on authentication endpoints
- **Role-Based Access Control** (RBAC)
- **Session-locked Exams** with anti-cheating measures

## 🌐 Localization

The system supports multiple languages:
- English (en)
- Arabic (ar)

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open-source and available under the [MIT License](LICENSE).

## 👨‍💻 Author

**Mohammed Ali**
- GitHub: [@Mohammed-Alijl](https://github.com/Mohammed-Alijl)

## 📧 Contact & Support

For questions, suggestions, or support, please open an issue on GitHub or contact the development team.

---
