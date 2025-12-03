<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Classrooms</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Classrooms you've joined</p>
            </div>

            {{-- Classrooms Grid --}}
            @if($classrooms->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No classrooms yet</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Browse available classrooms or join using a code.</p>
                    <div class="mt-6 flex items-center justify-center gap-3">
                        <a href="{{ route('classrooms.browse') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Browse Classrooms
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($classrooms as $classroom)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                            {{-- Card Header --}}
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                            {{ $classroom->title }}
                                        </h3>
                                        @if($classroom->course)
                                            <p class="text-xs text-indigo-600 dark:text-indigo-400 mb-2">
                                                📚 {{ $classroom->course->title }}
                                            </p>
                                        @endif
                                    </div>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                        @if($classroom->status === 'live') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($classroom->status === 'scheduled') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @endif">
                                        @if($classroom->status === 'live') 
                                            <span class="animate-pulse mr-1">🔴</span> Live
                                        @elseif($classroom->status === 'scheduled') 
                                            📅 Scheduled
                                        @else 
                                            ✓ Ended
                                        @endif
                                    </span>
                                </div>

                                @if($classroom->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                                        {{ $classroom->description }}
                                    </p>
                                @endif

                                {{-- Teacher Info --}}
                                <div class="mt-4 flex items-center gap-2">
                                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                                        <span class="text-indigo-600 dark:text-indigo-400 font-semibold text-xs">
                                            {{ strtoupper(substr($classroom->teacher->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-900 dark:text-white">
                                            {{ $classroom->teacher->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Teacher</p>
                                    </div>
                                </div>

                                {{-- Stats --}}
                                <div class="mt-4 flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        {{ $classroom->participants_count }}/{{ $classroom->max_participants }}
                                    </span>
                                    @if($classroom->scheduled_at && $classroom->status === 'scheduled')
                                        <span class="flex items-center text-xs">
                                            🕐 {{ $classroom->scheduled_at->format('M d, h:i A') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Card Actions --}}
                            <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-3 bg-gray-50 dark:bg-gray-700/50 flex items-center justify-between">
                                @if($classroom->status === 'live')
                                    <a href="{{ route('classrooms.room', $classroom) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        Join Room →
                                    </a>
                                @else
                                    <a href="{{ route('classrooms.show', $classroom) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        View Details
                                    </a>
                                @endif
                                
                                <form action="{{ route('classrooms.leave', $classroom) }}" method="POST" class="inline">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        onclick="return confirm('Are you sure you want to leave this classroom?')"
                                        class="text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-400"
                                    >
                                        Leave
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($classrooms->hasPages())
                    <div class="mt-8">
                        {{ $classrooms->links() }}
                    </div>
                @endif
            @endif

            {{-- Quick Join Section --}}
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Join a Classroom</h2>
                <form action="{{ route('classrooms.join-code') }}" method="POST" class="flex gap-3">
                    @csrf
                    <input 
                        type="text" 
                        name="join_code" 
                        placeholder="Enter classroom code (e.g., ABC12345)"
                        required
                        maxlength="8"
                        class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white uppercase"
                        style="text-transform: uppercase;"
                    >
                    <button 
                        type="submit" 
                        class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 shadow-sm transition-colors"
                    >
                        Join
                    </button>
                </form>
                @error('join_code')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Or <a href="{{ route('classrooms.browse') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">browse available classrooms</a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
