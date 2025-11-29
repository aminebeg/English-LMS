# Implementation Plan: Student Features

## Phase 1: Course Enrollment System

### Step 1: Update Routes
```php
// Add to web.php under the authenticated middleware
Route::middleware(['auth', 'approved'])->group(function () {
    // Student routes
    Route::middleware('role:student')->group(function () {
        Route::get('/courses/browse', [CourseController::class, 'browse'])->name('courses.browse');
        Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
        Route::get('/my-courses', [EnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('/my-courses/{course}', [EnrollmentController::class, 'show'])->name('enrollments.show');
    });
});
```

### Step 2: Create EnrollmentController
- `browse()` - Show all published courses available for enrollment
- `enroll()` - Enroll student in a course
- `index()` - Show student's enrolled courses
- `show()` - Show specific enrolled course with progress

### Step 3: Create Views
- `courses/browse.blade.php` - Course catalog for students
- `enrollments/index.blade.php` - My courses page
- `enrollments/show.blade.php` - Single course view for enrolled students

### Step 4: Update Course Model
Add helper methods:
- `isEnrolledBy($user)` - Check if user is enrolled
- `getProgressFor($user)` - Calculate completion percentage
- `getPublishedAttribute()` - Scope for published courses

---

## Phase 2: Student Lesson & Material Access

### Step 1: Create StudentLessonController
```php
Route::get('/learn/lessons/{lesson}', [StudentLessonController::class, 'show'])->name('learn.lessons.show');
Route::post('/learn/lessons/{lesson}/complete', [StudentLessonController::class, 'markComplete'])->name('learn.lessons.complete');
```

### Step 2: Create Progress Tracking
- New migration: `create_lesson_progress_table.php`
  - user_id
  - lesson_id
  - completed_at
  - time_spent (minutes)

### Step 3: Create Views
- `learn/lesson.blade.php` - Display lesson content with materials
- Progress indicators in enrollment views

---

## Phase 3: Test Taking & Results

### Step 1: Create TestAttemptController
```php
Route::get('/tests/{test}/start', [TestAttemptController::class, 'start'])->name('tests.start');
Route::post('/tests/{test}/submit', [TestAttemptController::class, 'submit'])->name('tests.submit');
Route::get('/test-results/{result}', [TestAttemptController::class, 'result'])->name('tests.result');
```

### Step 2: Update TestResult Model & Migration
Add fields:
- `user_id` (student taking the test)
- `test_id`
- `score` (percentage)
- `passed` (boolean)
- `answers` (JSON - stores user's answers)
- `completed_at`
- `time_taken` (minutes)

### Step 3: Implement Test Logic
**TestAttemptController methods:**

#### `start(Test $test)`
- Verify user is enrolled in course
- Check if user can take test (prerequisites met)
- Create new TestResult record (status: in_progress)
- Show test interface

#### `submit(Request $request, Test $test)`
- Validate all answers are provided
- Calculate score by comparing answers to correct answers
- Update TestResult with score and mark as completed
- Determine if passed based on passing_score
- Redirect to results page

### Step 4: Create Views
- `tests/take.blade.php` - Interface for taking test
  - Display all questions
  - Form with radio buttons (multiple choice), select (true/false), text input (short answer)
  - Submit button
  - Timer (optional)

- `tests/result.blade.php` - Show test results
  - Score and pass/fail status
  - Correct vs. user's answers
  - Option to retake (if allowed)

### Step 5: Grading Logic
```php
private function gradeTest(Test $test, array $answers): float
{
    $totalQuestions = $test->questions->count();
    $correctAnswers = 0;
    
    foreach ($test->questions as $question) {
        $userAnswer = $answers[$question->id] ?? '';
        
        if ($this->isCorrectAnswer($question, $userAnswer)) {
            $correctAnswers++;
        }
    }
    
    return ($correctAnswers / $totalQuestions) * 100;
}

private function isCorrectAnswer(Question $question, string $userAnswer): bool
{
    // For short answer, might want fuzzy matching or manual grading
    if ($question->type === 'short_answer') {
        return strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer));
    }
    
    // Exact match for multiple choice and true/false
    return trim($userAnswer) === trim($question->correct_answer);
}
```

---

## Phase 4: Dashboard Enhancements

### Student Dashboard
- List of enrolled courses with progress bars
- Upcoming tests
- Recent test results
- Continue learning button for each course

### Tutor Dashboard
- Course statistics
- Student enrollments
- Recent test submissions
- Average scores per test

---

## Phase 5: Additional Features

### 1. Test Retakes
- Add `max_attempts` field to tests table
- Track attempt number in test_results
- Show best score or latest score

### 2. Prerequisites
- Add `prerequisite_test_id` to tests table
- Prevent taking test until prerequisite is passed

### 3. Time Limits
- Add `time_limit` (minutes) to tests table
- JavaScript timer in test-taking interface
- Auto-submit when time expires

### 4. Question Shuffling
- Randomize question order for each attempt
- Randomize multiple choice options order

### 5. Detailed Analytics
- Time spent per question
- Most commonly missed questions
- Student performance trends

---

## Implementation Order (Recommended)

1. ✅ **[DONE]** Test & Question Management (Tutor side)
2. **Course Enrollment** - Let students browse and enroll
3. **Lesson Access** - Let students view lessons and materials
4. **Test Taking** - Core test-taking functionality
5. **Test Results** - Display results and feedback
6. **Dashboard Updates** - Show progress and stats
7. **Advanced Features** - Retakes, prerequisites, time limits, etc.

---

## Files to Create (Phase 2-3)

### Controllers
- `app/Http/Controllers/EnrollmentController.php`
- `app/Http/Controllers/StudentLessonController.php`
- `app/Http/Controllers/TestAttemptController.php`

### Migrations
- `create_lesson_progress_table.php`
- `add_test_attempt_fields_to_test_results.php`

### Views
- `resources/views/courses/browse.blade.php`
- `resources/views/enrollments/index.blade.php`
- `resources/views/enrollments/show.blade.php`
- `resources/views/learn/lesson.blade.php`
- `resources/views/tests/take.blade.php`
- `resources/views/tests/result.blade.php`

### Policies
- Update `CoursePolicy.php` to add `enroll` and `view` methods
- Update `TestPolicy.php` to add `take` method

---

## Testing Checklist

- [ ] Tutor can create tests with questions
- [ ] Student can browse published courses
- [ ] Student can enroll in courses
- [ ] Student can view enrolled course content
- [ ] Student can take tests
- [ ] System correctly grades multiple choice questions
- [ ] System correctly grades true/false questions
- [ ] System correctly grades short answer questions
- [ ] Student can see test results
- [ ] Student cannot take test from course they're not enrolled in
- [ ] Student cannot access unpublished courses
- [ ] Progress tracking works correctly
