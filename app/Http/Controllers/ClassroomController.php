<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassroomParticipant;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    /**
     * Display a listing of classrooms (Teacher's classrooms)
     */
    public function index()
    {
        $classrooms = Classroom::where('teacher_id', auth()->id())
            ->withCount('participants')
            ->with('course')
            ->latest()
            ->paginate(12);

        return view('classrooms.index', compact('classrooms'));
    }

    /**
     * Display public classrooms for students to browse
     */
    public function browse()
    {
        $classrooms = Classroom::public()
            ->active()
            ->with(['teacher', 'course'])
            ->withCount('participants')
            ->latest()
            ->paginate(12);

        return view('classrooms.browse', compact('classrooms'));
    }

    /**
     * Display student's joined classrooms
     */
    public function myClassrooms()
    {
        $participantIds = ClassroomParticipant::where('user_id', auth()->id())
            ->pluck('classroom_id');

        $classrooms = Classroom::whereIn('id', $participantIds)
            ->with(['teacher', 'course'])
            ->withCount('participants')
            ->latest()
            ->paginate(12);

        return view('classrooms.my-classrooms', compact('classrooms'));
    }

    /**
     * Show the form for creating a new classroom
     */
    public function create()
    {
        $this->authorize('create', Classroom::class);
        
        $courses = Course::where('tutor_id', auth()->id())
            ->orderBy('title')
            ->get();

        return view('classrooms.create', compact('courses'));
    }

    /**
     * Store a newly created classroom
     */
    public function store(Request $request)
    {
        $this->authorize('create', Classroom::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'max_participants' => 'required|integer|min:2|max:500',
            'price' => 'nullable|numeric|min:0',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'scheduled_at' => 'nullable|date|after:now',
            'duration_minutes' => 'nullable|integer|min:15|max:480',
        ]);

        $validated['teacher_id'] = auth()->id();
        $validated['is_public'] = $request->has('is_public');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['price'] = $request->input('price', 0);

        $classroom = Classroom::create($validated);

        return redirect()->route('classrooms.show', $classroom)
            ->with('status', 'Classroom created successfully! 🎉');
    }

    /**
     * Display the specified classroom
     */
    public function show(Classroom $classroom)
    {
        $this->authorize('view', $classroom);

        $classroom->load(['teacher', 'course', 'participants.user', 'sessions']);
        
        // Check if current user is a participant
        $isParticipant = $classroom->participants()
            ->where('user_id', auth()->id())
            ->exists();

        return view('classrooms.show', compact('classroom', 'isParticipant'));
    }

    /**
     * Show the classroom room (live session)
     */
    public function room(Classroom $classroom)
    {
        $this->authorize('join', $classroom);

        // Join or update participant
        $participant = ClassroomParticipant::firstOrCreate(
            [
                'classroom_id' => $classroom->id,
                'user_id' => auth()->id(),
            ],
            [
                'role' => $classroom->isTeacher(auth()->user()) ? 'teacher' : 'student',
                'joined_at' => now(),
            ]
        );

        $participant->join();

        $classroom->load(['teacher', 'participants.user']);

        // Get or create active session
        $session = $classroom->sessions()
            ->whereNull('ended_at')
            ->latest()
            ->first();

        return view('classrooms.room', compact('classroom', 'session'));
    }

    /**
     * Join classroom via join code
     */
    public function joinByCode(Request $request)
    {
        $request->validate([
            'join_code' => 'required|string|size:8',
        ]);

        $classroom = Classroom::where('join_code', strtoupper($request->join_code))
            ->active()
            ->first();

        if (!$classroom) {
            return back()->withErrors(['join_code' => 'Invalid join code.']);
        }

        if (!$classroom->canJoin()) {
            return back()->withErrors(['join_code' => 'Classroom is full or not available.']);
        }

        return redirect()->route('classrooms.room', $classroom);
    }

    /**
     * Show the form for editing the classroom
     */
    public function edit(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $courses = Course::where('tutor_id', auth()->id())
            ->orderBy('title')
            ->get();

        return view('classrooms.edit', compact('classroom', 'courses'));
    }

    /**
     * Update the specified classroom
     */
    public function update(Request $request, Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'max_participants' => 'required|integer|min:2|max:500',
            'price' => 'nullable|numeric|min:0',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'scheduled_at' => 'nullable|date',
            'duration_minutes' => 'nullable|integer|min:15|max:480',
        ]);

        $validated['is_public'] = $request->has('is_public');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['price'] = $request->input('price', 0);

        $classroom->update($validated);

        return redirect()->route('classrooms.show', $classroom)
            ->with('status', 'Classroom updated successfully! ✅');
    }

    /**
     * Start a live session
     */
    public function startSession(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $session = $classroom->startSession();

        return redirect()->route('classrooms.room', $classroom)
            ->with('status', 'Session started! 🎥');
    }

    /**
     * End a live session
     */
    public function endSession(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $classroom->endSession();

        return redirect()->route('classrooms.show', $classroom)
            ->with('status', 'Session ended successfully! 👋');
    }

    /**
     * Leave classroom (student)
     */
    public function leave(Classroom $classroom)
    {
        $participant = ClassroomParticipant::where('classroom_id', $classroom->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($participant) {
            $participant->leave();
        }

        return redirect()->route('classrooms.browse')
            ->with('status', 'You left the classroom.');
    }

    /**
     * Remove the specified classroom
     */
    public function destroy(Classroom $classroom)
    {
        $this->authorize('delete', $classroom);

        $classroom->delete();

        return redirect()->route('classrooms.index')
            ->with('status', 'Classroom deleted successfully!');
    }
}
