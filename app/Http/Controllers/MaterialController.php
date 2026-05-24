<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'type' => 'required|string|in:video,text,audio,file',
            'content' => 'required_unless:type,file|nullable|string',
            'file' => 'required_if:type,file|nullable|file|max:10240', // 10MB
        ]);

        $materialData = [
            'lesson_id' => $lesson->id,
            'title' => $validated['title'],
            'type' => $validated['type'],
            'content' => $validated['content'] ?? null,
        ];

        if ($request->hasFile('file') && $validated['type'] === 'file') {
            $file = $request->file('file');
            $path = $file->store('lesson-materials/' . $lesson->id, 'public');

            $materialData['file_path'] = $path;
            $materialData['file_name'] = $file->getClientOriginalName();
            $materialData['file_size'] = $file->getSize();
            $materialData['mime_type'] = $file->getMimeType();
        }

        $lesson->materials()->create($materialData);

        return redirect()->route('lessons.edit', $lesson)->with('status', 'Material added successfully!');
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
            'type' => 'required|string|in:video,text,audio,file',
            'content' => 'required_if:type,text,video,audio|nullable|string',
            'file' => 'nullable|file|max:10240', // 10MB
        ]);

        $materialData = [
            'title' => $validated['title'],
            'type' => $validated['type'],
            'content' => $validated['content'] ?? null,
        ];

        // Handle file upload if provided
        if ($request->hasFile('file') && $validated['type'] === 'file') {
            $file = $request->file('file');

            // Delete old file if it exists
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }

            // Store new file
            $path = $file->store('lesson-materials/' . $material->lesson->id, 'public');

            $materialData['file_path'] = $path;
            $materialData['file_name'] = $file->getClientOriginalName();
            $materialData['file_size'] = $file->getSize();
            $materialData['mime_type'] = $file->getMimeType();
        }

        $material->update($materialData);

        return redirect()->route('lessons.edit', $material->lesson)->with('status', 'Material updated!');
    }

    public function destroy(Material $material)
    {
        $lesson = $material->lesson;
        $this->authorize('update', $lesson->course);

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('lessons.edit', $lesson)->with('status', 'Material removed!');
    }

    public function download(Material $material)
    {
        // Students should be able to download if they are enrolled
        // $this->authorize('view', $material->lesson->course);

        if (!$material->file_path) {
            abort(404);
        }

        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }
}
