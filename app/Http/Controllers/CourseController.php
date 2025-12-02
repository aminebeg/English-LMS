<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Course::class, 'course');
    }

    public function index()
    {
        $courses = auth()->user()->teachingCourses()->with('lessons')->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'nullable|string|in:A1,A2,B1,B2,C1,C2',
            'type' => 'required|string|in:adult,kid,researcher',
            'category' => 'nullable|string|max:255',
            'difficulty' => 'nullable|string|in:beginner,intermediate,advanced,expert',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'duration_weeks' => 'nullable|integer|min:1',
            'estimated_hours' => 'nullable|integer|min:1',
            'instructor_bio' => 'nullable|string',
            'max_students' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:50',
            'certificate_template' => 'nullable|string|in:standard,premium,professional',
            'tags' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'prerequisites' => 'nullable|string',
            'has_payment_plan' => 'boolean',
            'has_certificate' => 'boolean',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'thumbnail' => 'nullable|image|max:2048',
            'preview_video' => 'nullable|string|max:500',
        ]);

        // Handle JSON fields
        if (isset($validated['tags'])) {
            $validated['tags'] = json_decode($validated['tags'], true);
        }
        if (isset($validated['learning_outcomes'])) {
            $validated['learning_outcomes'] = json_decode($validated['learning_outcomes'], true);
        }
        if (isset($validated['prerequisites'])) {
            $validated['prerequisites'] = json_decode($validated['prerequisites'], true);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('course-thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }

        // Set default values for checkboxes
        $validated['has_payment_plan'] = $request->has('has_payment_plan');
        $validated['has_certificate'] = $request->has('has_certificate') ? true : false;
        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');

        $course = auth()->user()->teachingCourses()->create($validated);

        return redirect()->route('courses.show', $course)->with('status', 'Course created successfully! 🎉');
    }

    public function show(Course $course)
    {
        $course->load('lessons.materials', 'tests');
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $course->load('tests.questions', 'sections.lessons');
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'nullable|string|in:A1,A2,B1,B2,C1,C2',
            'type' => 'required|string|in:adult,kid,researcher',
            'category' => 'nullable|string|max:255',
            'difficulty' => 'nullable|string|in:beginner,intermediate,advanced,expert',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'duration_weeks' => 'nullable|integer|min:1',
            'estimated_hours' => 'nullable|integer|min:1',
            'instructor_bio' => 'nullable|string',
            'max_students' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:50',
            'certificate_template' => 'nullable|string|in:standard,premium,professional',
            'tags' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'prerequisites' => 'nullable|string',
            'has_payment_plan' => 'boolean',
            'has_certificate' => 'boolean',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'thumbnail' => 'nullable|image|max:2048',
            'preview_video' => 'nullable|string|max:500',
        ]);

        // Handle JSON fields
        if (isset($validated['tags'])) {
            $validated['tags'] = json_decode($validated['tags'], true);
        }
        if (isset($validated['learning_outcomes'])) {
            $validated['learning_outcomes'] = json_decode($validated['learning_outcomes'], true);
        }
        if (isset($validated['prerequisites'])) {
            $validated['prerequisites'] = json_decode($validated['prerequisites'], true);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail && \Storage::disk('public')->exists($course->thumbnail)) {
                \Storage::disk('public')->delete($course->thumbnail);
            }
            $path = $request->file('thumbnail')->store('course-thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }

        // Set default values for checkboxes
        $validated['has_payment_plan'] = $request->has('has_payment_plan');
        $validated['has_certificate'] = $request->has('has_certificate');
        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');

        $course->update($validated);

        return redirect()->route('courses.show', $course)->with('status', 'Course updated successfully! ✅');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('status', 'Course deleted!');
    }
}
