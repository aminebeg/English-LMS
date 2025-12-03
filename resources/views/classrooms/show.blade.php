<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $classroom->title }}</h1>
                        @if($classroom->course)
                            <p class="text-sm text-indigo-600 dark:text-indigo-400 mt-1">
                                📚 {{ $classroom->course->title }}
                            </p>
                        @endif
                    </div>
                    
                    {{-- Status Badge --}}
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium
                        @if($classroom->status === 'live') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($classroom->status === 'scheduled') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                        @endif">
                        @if($classroom->status === 'live') 
                            <span class="animate-pulse mr-1">🔴</span> Live Now
                        @elseif($classroom->status === 'scheduled') 
                            📅 Scheduled
                        @else 
                            ✓ Ended
                        @endif
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Description --}}
                    @if($classroom->description)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">About This Classroom</h2>
                            <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $classroom->description }}</p>
                        </div>
                    @endif

                    {{-- Participants List --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Participants ({{ $classroom->participants_count }}/{{ $classroom->max_participants }})
                        </h2>
                        
                        @if($classroom->participants->isEmpty())
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-8">
                                No participants yet
                            </p>
                        @else
                            <div class="space-y-3">
                                @foreach($classroom->participants as $participant)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                                                <span class="text-indigo-600 dark:text-indigo-400 font-semibold">
                                                    {{ strtoupper(substr($participant->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $participant->user->name }}
                                                    @if($participant->user_id === $classroom->teacher_id)
                                                        <span class="ml-1 text-xs text-indigo-600 dark:text-indigo-400">(Teacher)</span>
                                                    @endif
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    Joined {{ $participant->joined_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        @if($participant->is_active)
                                            <span class="text-xs text-green-600 dark:text-green-400 font-medium">Active</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Session History --}}
                    @if($classroom->sessions->isNotEmpty())
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Session History</h2>
                            <div class="space-y-3">
                                @foreach($classroom->sessions->take(5) as $session)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $session->started_at->format('M d, Y - h:i A') }}
                                            </p>
                                            @if($session->ended_at)
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    Duration: {{ $session->duration_minutes }} minutes
                                                </p>
                                            @else
                                                <p class="text-xs text-green-600 dark:text-green-400">
                                                    Currently live
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    
                    {{-- Quick Info --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Classroom Info</h3>
                        
                        <div class="space-y-3">
                            {{-- Teacher --}}
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Teacher</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $classroom->teacher->name }}</p>
                            </div>

                            {{-- Join Code --}}
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Join Code</p>
                                <div class="flex items-center gap-2">
                                    <code class="flex-1 px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded font-mono text-sm">
                                        {{ $classroom->join_code }}
                                    </code>
                                    <button 
                                        onclick="navigator.clipboard.writeText('{{ $classroom->join_code }}')"
                                        class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition-colors"
                                        title="Copy code"
                                    >
                                        📋
                                    </button>
                                </div>
                            </div>

                            {{-- Capacity --}}
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Capacity</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $classroom->participants_count }} / {{ $classroom->max_participants }} participants
                                </p>
                            </div>

                            {{-- Schedule --}}
                            @if($classroom->scheduled_at)
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Scheduled For</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $classroom->scheduled_at->format('M d, Y - h:i A') }}
                                    </p>
                                </div>
                            @endif

                            {{-- Visibility --}}
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Visibility</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $classroom->is_public ? '🌐 Public' : '🔒 Private' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                        
                        <div class="space-y-3">
                            @can('update', $classroom)
                                {{-- Teacher Actions --}}
                                @if($classroom->status === 'live')
                                    <a 
                                        href="{{ route('classrooms.room', $classroom) }}" 
                                        class="block w-full px-4 py-2 bg-indigo-600 text-white text-center font-medium rounded-lg hover:bg-indigo-700 transition-colors"
                                    >
                                        Join Room
                                    </a>
                                    <form action="{{ route('classrooms.end', $classroom) }}" method="POST">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="w-full px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors"
                                        >
                                            End Session
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('classrooms.start', $classroom) }}" method="POST">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="w-full px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors"
                                        >
                                            Start Session
                                        </button>
                                    </form>
                                @endif

                                <a 
                                    href="{{ route('classrooms.edit', $classroom) }}" 
                                    class="block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-center font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                                >
                                    Edit Classroom
                                </a>
                            @else
                                {{-- Student Actions --}}
                                @if($isParticipant)
                                    @if($classroom->status === 'live')
                                        <a 
                                            href="{{ route('classrooms.room', $classroom) }}" 
                                            class="block w-full px-4 py-2 bg-indigo-600 text-white text-center font-medium rounded-lg hover:bg-indigo-700 transition-colors"
                                        >
                                            Join Room
                                        </a>
                                    @endif
                                    <form action="{{ route('classrooms.leave', $classroom) }}" method="POST">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="w-full px-4 py-2 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 font-medium rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition-colors"
                                        >
                                            Leave Classroom
                                        </button>
                                    </form>
                                @else
                                    @can('join', $classroom)
                                        <form action="{{ route('classrooms.join-code') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="join_code" value="{{ $classroom->join_code }}">
                                            <button 
                                                type="submit" 
                                                class="w-full px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors"
                                            >
                                                Join Classroom
                                            </button>
                                        </form>
                                    @endcan
                                @endif
                            @endcan

                            <a 
                                href="{{ route('classrooms.index') }}" 
                                class="block w-full px-4 py-2 text-gray-700 dark:text-gray-300 text-center font-medium hover:text-gray-900 dark:hover:text-white transition-colors"
                            >
                                ← Back to Classrooms
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
