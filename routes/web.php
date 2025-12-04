<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\TutorRegistrationController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\TestAttemptController;
use App\Http\Controllers\StudentLessonController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\CourseSectionController;
use App\Http\Controllers\CourseStudentController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/become-tutor', [TutorRegistrationController::class, 'create'])->name('tutor.register.form');
Route::post('/become-tutor', [TutorRegistrationController::class, 'store'])->name('tutor.register');

// Public course preview
Route::get('/courses/{course}/preview', [\App\Http\Controllers\CoursePreviewController::class, 'show'])->name('courses.preview');

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::middleware('role:editor')->group(function () {
        Route::get('/editor', [EditorController::class, 'index'])->name('editor.dashboard');
        Route::post('/editor/approve/{user}', [EditorController::class, 'approve'])->name('editor.approve');
    });

    // Student routes for course browsing and enrollment
    Route::middleware('role:student')->group(function () {
        Route::get('/courses/browse', [EnrollmentController::class, 'browse'])->name('courses.browse');
        Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
        Route::get('/my-courses', [EnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('/my-courses/{course}', [EnrollmentController::class, 'show'])->name('enrollments.show');
        
        // Lesson viewing
        Route::get('/learn/lessons/{lesson}', [StudentLessonController::class, 'show'])->name('learn.lessons.show');
        Route::post('/learn/lessons/{lesson}/complete', [StudentLessonController::class, 'markComplete'])->name('learn.lessons.complete');
        Route::post('/learn/lessons/{lesson}/incomplete', [StudentLessonController::class, 'markIncomplete'])->name('learn.lessons.incomplete');
        
        // Test taking
        Route::get('/my-test-results', [TestAttemptController::class, 'index'])->name('tests.my-results');
        Route::get('/tests/{test}/start', [TestAttemptController::class, 'start'])->name('tests.start');
        Route::post('/tests/{test}/submit', [TestAttemptController::class, 'submit'])->name('tests.submit');
        Route::get('/test-results/{testResult}', [TestAttemptController::class, 'result'])->name('tests.result');
        
        // Certificate
        Route::get('/courses/{course}/certificate', [\App\Http\Controllers\CertificateController::class, 'download'])->name('certificates.download');
        

    });

    Route::middleware('role:tutor')->group(function () {
        Route::resource('courses', CourseController::class);
        Route::resource('lessons', LessonController::class)->except(['index']);
        Route::resource('materials', MaterialController::class)->except(['index']);
        Route::resource('tests', TestController::class)->except(['index']);
        Route::get('/tests/{test}/results', [TestController::class, 'results'])->name('tests.results');
        Route::post('/tests/{test}/duplicate', [TestController::class, 'duplicate'])->name('tests.duplicate');
        Route::post('/courses/{course}/tests/reorder', [TestController::class, 'reorder'])->name('tests.reorder');
        Route::resource('questions', QuestionController::class)->except(['index', 'show']);
        
        // Sections
        Route::post('/courses/{course}/sections', [CourseSectionController::class, 'store'])->name('courses.sections.store');
        Route::put('/sections/{section}', [CourseSectionController::class, 'update'])->name('sections.update');
        Route::delete('/sections/{section}', [CourseSectionController::class, 'destroy'])->name('sections.destroy');

        // Students
        Route::get('/courses/{course}/students', [CourseStudentController::class, 'index'])->name('courses.students.index');
        Route::delete('/courses/{course}/students/{student}', [CourseStudentController::class, 'destroy'])->name('courses.students.destroy');
        

    });
    


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/ai/generate', [AIController::class, 'generate'])->name('ai.generate');
    Route::post('/ai/generate-questions', [AIController::class, 'generateQuestions'])->name('ai.generate-questions');

    // Media uploads
    Route::post('/media/upload', [\App\Http\Controllers\MediaController::class, 'upload'])->name('media.upload');
    Route::delete('/media/delete', [\App\Http\Controllers\MediaController::class, 'delete'])->name('media.delete');
});

require __DIR__.'/auth.php';
