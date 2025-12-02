<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Http\Request;

class CourseSectionController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->sections()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'order' => $course->sections()->max('order') + 1
        ]);

        return back()->with('success', 'Section created successfully.');
    }

    public function update(Request $request, CourseSection $section)
    {
        $this->authorize('update', $section->course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $section->update($validated);

        return back()->with('success', 'Section updated successfully.');
    }

    public function destroy(CourseSection $section)
    {
        $this->authorize('update', $section->course);
        
        $section->delete();
        return back()->with('success', 'Section deleted successfully.');
    }
}
