# English LMS - Learning Management System

A comprehensive, modern Learning Management System designed specifically for English language education. Built with Laravel 11 and featuring comprehensive testing, and a beautiful freemium course marketplace.

## ✨ Key Features

- 🎓 **Complete Course Management** - Create structured courses with sections, lessons, and materials

- 📝 **Flexible Testing System** - Quizzes and exams with multiple question types
- 💎 **Freemium Course Preview** - Allow students to preview lessons before enrolling
- 👥 **Role-Based Access** - Separate interfaces for Students, Tutors, and Editors
- 📊 **Progress Tracking** - Automatic student progress calculation
- 🎖️ **Certificate Generation** - Auto-generated certificates upon course completion
- 🌙 **Modern UI/UX** - Premium design with dark mode support
- 📱 **Responsive Design** - Works seamlessly on all devices

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/MariaDB

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd English-LMS
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` and set your database credentials:
   ```
   DB_DATABASE=english_lms
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run dev
   ```

7. **Start the server**
   ```bash
   php artisan serve
   ```

8. **Visit** `http://localhost:8000`

## 🔑 Default Test Accounts

After seeding, you can login with:

| Role | Email | Password |
|------|-------|----------|
| Student | student@test.com | password |
| Tutor | tutor@test.com | password |
| Editor | editor@test.com | password |

## 📚 Documentation

For complete feature documentation, see [PLATFORM_FEATURES.md](PLATFORM_FEATURES.md)

### Quick Links:
- **User Roles & Authentication** - How the role system works
- **Course Management** - Creating and managing courses
- **Testing & Assessments** - Quiz and exam creation

- **Student Experience** - Learning and progress tracking
- **Freemium System** - Course preview functionality

## 🛠️ Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Tailwind CSS + Alpine.js
- **Database**: MySQL

- **Build**: Vite

## 📋 Main Features Overview

### For Students:
- Browse and preview courses
- Enroll in free or paid courses
- Watch lessons and download materials
- Take quizzes and exams

- Track learning progress
- Download completion certificates

### For Tutors:
- Create and publish courses
- Design curriculum with sections and lessons
- Upload learning materials
- Create tests with various question types

- Manage student enrollments
- Track student progress

### For Editors:
- Approve tutor applications
- Manage all users
- Oversee all courses
- Platform administration

## 🎯 Course Structure

```
Course
├── Sections (Modules)
│   ├── Lessons
│   │   ├── Content
│   │   ├── Materials
│   │   └── Tests (lesson-level quizzes)
│   └── Tests (section-level tests)
└── Tests (course-level final exams)
```



## 📝 Testing System

Support for multiple question types:
- **Multiple Choice** - Up to 4 options
- **True/False** - Simple boolean questions  
- **Short Answer** - Text-based responses

Flexible test placement:
- Course-level (final exams)
- Section-level (module tests)
- Lesson-level (quick quizzes)

## 💡 Freemium Model

- Tutors can mark lessons as "Free Preview"
- Students can preview courses before enrolling
- Public course detail pages
- Clear free vs paid indicators
- Drives enrollment conversions

## 🔐 Security Features

- Role-based access control
- Policy-based authorization
- CSRF protection
- Secure authentication (Laravel Breeze)
- Password hashing
- Safe file uploads

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 💬 Support

For issues and questions, please open an issue in the repository.

---

**Built with ❤️ for English Language Education**
