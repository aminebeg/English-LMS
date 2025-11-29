<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Lesson;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function create(Request $request)
    {
        $lesson = Lesson::findOrFail($request->lesson);
        $this->authorize('update', $lesson->course);
        return view('materials.create', compact('lesson'));
    }

    public function store(Request $request)
    {
        $lesson = Lesson::findOrFail($request->lesson_id);
        $this->authorize('update', $lesson->course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:video,text,audio',
            'content' => 'required|string',
        ]);

        $lesson->materials()->create($validated);

        return redirect()->route('lessons.show', $lesson)->with('status', 'Material created!');
    }

    public function show(Material $material)
    {
        $this->authorize('view', $material->lesson->course);
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $this->authorize('update', $material->lesson->course);
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $this->authorize('update', $material->lesson->course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:video,text,audio',
            'content' => 'required|string',
        ]);

        $material->update($validated);

        return redirect()->route('materials.show', $material)->with('status', 'Material updated!');
    }

    public function destroy(Material $material)
    {
        $lesson = $material->lesson;
        $this->authorize('update', $lesson->course);
        $material->delete();

        return redirect()->route('lessons.show', $lesson)->with('status', 'Material deleted!');
    }
}
