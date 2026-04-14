<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Upload a media file (image, video, or audio)
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:102400', // 100MB max
            'type' => 'required|in:image,video,audio',
        ]);

        $file = $request->file('file');
        $type = $request->input('type');

        // Validate file type
        $allowedMimes = [
            'image' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'],
            'video' => ['video/mp4', 'video/webm', 'video/ogg', 'video/quicktime'],
            'audio' => ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg', 'audio/webm'],
        ];

        if (!in_array($file->getMimeType(), $allowedMimes[$type])) {
            return response()->json([
                'error' => 'Invalid file type. Allowed: ' . implode(', ', $allowedMimes[$type])
            ], 422);
        }

        // Generate unique filename
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $folder = 'lessons/' . $type . 's'; // lessons/images, lessons/videos, lessons/audios

        // Store the file
        $path = $file->storeAs($folder, $filename, 'public');

        if (!$path) {
            return response()->json(['error' => 'Failed to upload file'], 500);
        }

        return response()->json([
            'success' => true,
            'url' => Storage::url($path),
            'path' => $path,
            'filename' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'type' => $type,
        ]);
    }

    /**
     * Delete a media file
     */
    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = $request->input('path');

        // Ensure the path is within the lessons folder for security
        if (!Str::startsWith($path, 'lessons/')) {
            return response()->json(['error' => 'Invalid path'], 403);
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}
