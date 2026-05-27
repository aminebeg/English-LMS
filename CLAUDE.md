# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**English LMS** is a Laravel 12 Learning Management System for English language education with:
- Three user roles: Student (open registration), Tutor (application required), Editor (admin)
- Freemium course marketplace with preview functionality
- Complete testing/assessment system with multiple question types
- Certificate generation upon course completion

## Tech Stack

- **PHP**: 8.4+
- **Laravel**: 12.x
- **Frontend**: Tailwind CSS 4, Alpine.js
- **Build**: Vite
- **Database**: MySQL
- **Testing**: PHPUnit 11.x

## Common Commands

### Development
```bash
# Start all dev services concurrently (server, queue, logs, vite)
composer dev

# Or start individual services:
php artisan serve          # Start Laravel server
php artisan queue:listen   # Listen to job queue
npm run dev                # Frontend dev server
```

### Building
```bash
npm run build              # Build frontend assets for production
```

### Testing
```bash
# Run all tests
composer test

# Run specific test file
./vendor/bin/phpunit tests/Feature/CourseTest.php

# Run tests with verbose output
./vendor/bin/phpunit --testdox

# Run a single test method
./vendor/bin/phpunit tests/Feature/ExampleTest.php --filter testExecuteArtisanCommands
```

### Database
```bash
# Run migrations
php artisan migrate

# Seed test data (for development)
php artisan db:seed --class=TestUsersSeeder

# Reset and migrate fresh
php artisan migrate:fresh --seed
```

## Architecture

### User Roles & Authorization
- Three roles managed via `spatie/laravel-permission`: Student, Tutor, Editor
- `EnsureApproved` middleware: Required for tutors before editor approval
- `EnsureRole` middleware: Role-based access control
- Tutor registrations go through `/become-tutor` workflow requiring editor approval

### Course Structure
```
Course
├── Sections (modules)
│   ├── Lessons
│   │   ├── Content (HTML/Markdown)
│   │   ├── Materials (files)
│   │   └── Lesson-level Tests (quizzes)
│   └── Section-level Tests
└── Course-level Final Tests
```

### Testing System
Three types of tests supported:
1. **Multiple Choice** - Up to 4 options
2. **True/False** - Binary answers
3. **Short Answer** - Text responses

Tests can be attached to: Courses (final exams), Sections, or Lessons

### Freemium System
- Tutors mark lessons as "is_preview = true"
- Students can preview courses via public routes before enrolling
- Course preview pages at `/courses/{course}/preview`

### Models Overview
- `User` - Extends base with roles, tutor_bio, pending_tutor_application
- `Course` - Title, description, level, price, image, published status
- `CourseSection` - Module/section within a course
- `Lesson` - Content with `is_preview` flag for freemium
- `Material` - Uploaded files for lessons
- `Test` - Quizzes/exams (polymorphic: course/section/lesson tests)
- `TestResult` - Student test attempts and scores
- `Enrollment` - Student-course relationships
- `Question` - Test questions with answer choices
- `QuestionAnswer` - Answer options for multiple choice/true-false

### Key Controllers
- `CourseController` - CRUD for courses (tutor routes)
- `CourseSectionController` - Section management
- `LessonController` - Lesson CRUD
- `MaterialController` - File uploads/downloads
- `TestController` - Test CRUD + results
- `QuestionController` - Question CRUD (show/index excluded)
- `TestAttemptController` - Student test-taking interface
- `EnrollmentController` - Course browsing + enrollment
- `CourseStudentController` - Student management for tutors
- `StudentLessonController` - Progress tracking
- `CoursePreviewController` - Public course preview
- `CertificateController` - PDF certificate generation
- `TutorRegistrationController` - Tutor application workflow
- `EditorController` - Editor dashboard + user approvals

### View Components
Located in `resources/views/components/`:
- `application-logo` - Logo display
- `auth-session-status` - Login state indicator
- `input-error` - Error message display
- `input-label` - Form labels
- `modal` - Modal dialogs
- `dropdown` / `dropdown-link` - Navigation menus
- `primary-button` / `secondary-button` / `danger-button`
- `text-input` - Form inputs

### Layouts
- `resources/views/layouts/guest.blade.php` - Public layouts (auth, preview)
- `resources/views/layouts/app.blade.php` - Authenticated layouts
- Role-specific views in `resources/views/courses/`, `resources/views/lessons/`, etc.

### Database Seeding
```bash
php artisan db:seed --class=RoleSeeder       # Create roles
php artisan db:seed --class=TestUsersSeeder  # Create test accounts
php artisan db:seed --class=EditorSeeder     # Create editor account
```

Default test accounts:
- Student: `student@test.com` / `password123`
- Tutor: `tutor@test.com` / `password123` (pending approval)
- Editor: `editor@test.com` / `password123`

### Routes Structure
- `/` - Welcome page
- `/become-tutor` - Tutor registration form (public)
- `/courses/{course}/preview` - Public course preview
- `/dashboard` - Authenticated dashboard
- `/editor` - Editor dashboard (requires editor role)
- `/courses/browse` - Student course listing
- `/my-courses` - Student enrolled courses
- `/courses/{course}` - Tutor course CRUD
- `/tests/{test}` - Test CRUD + results (tutor)
- `/tests/{test}/start` - Student test taking
- `/tests/{test}/submit` - Test submission & grading
- `/certificates/{course}` - Certificate download

### Policies
- `CoursePolicy` - Course access/management permissions

### Services
- `AIService` - AI integration (if implemented)

### Important Files
- `composer.json` - PHP dependencies and scripts
- `package.json` - Node.js dependencies
- `phpunit.xml` - Test configuration
- `tailwind.config.js` - Tailwind CSS configuration
- `vite.config.js` - Vite bundler configuration

### Security Notes
- Password-based authentication (Laravel Breeze)
- CSRF protection on all forms
- Policy-based authorization
- CSRF protection on all forms

### Development Tips

1. **Running with hot reload**: `composer dev` runs all services concurrently
2. **Testing**: Always run `composer test` before committing
3. **Migrations**: Run `php artisan migrate` after database changes
4. **Environment**: Ensure `.env` is configured before running artisan commands
5. **Assets**: Build with `npm run build` for production, `npm run dev` for development
6. **Queue**: Queue worker runs with `php artisan queue:listen --tries=1`
7. **Logs**: View logs during `composer dev` via the logs terminal

### Code Style

- Laravel follows PSR-12
- Use type hints and return types
- Eloquent models with fillable properties for mass assignment
- Controllers extend `App\Http\Controllers\Controller`
- Tests use Pest or PHPUnit with BDD style

### Data Models Quick Reference

| Model | Key Fields |
|-------|------------|
| User | id, name, email, password, role_id, pending_tutor_application, approved |
| Course | title, description, level, price, image, published |
| CourseSection | course_id, title, order |
| Lesson | course_section_id, title, order, content, is_preview, duration |
| Material | lesson_id, file_path, file_name, file_type |
| Test | course_id/section_id/lesson_id, title, order, type |
| Enrollment | student_id, course_id, enrolled_at, is_free |
| Question | test_id, question_text, question_type |
| QuestionAnswer | question_id, answer_text, is_correct |
| TestResult | test_id, user_id, score, started_at, completed_at |
