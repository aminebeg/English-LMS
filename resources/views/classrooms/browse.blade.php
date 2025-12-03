<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Browse Classrooms</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Join live virtual classrooms and learn from expert teachers</p>
            </div>



            {{-- Classrooms Grid --}}
            @if($classrooms->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No classrooms available</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Check back later for new live sessions.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($classrooms as $classroom)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                            {{-- Card Header --}}
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                            {{ $classroom->title }}
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            by {{ $classroom->teacher->name }}
                                        </p>
                                    </div>
                                    @if($classroom->status === 'live')
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 animate-pulse">
                                            🔴 Live
                                        </span>
                                    @endif
                                </div>

                                @if($classroom->course)
                                    <div class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 mb-3">
                                        📚 {{ $classroom->course->title }}
                                    </div>
                                @endif

                                @if($classroom->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 mb-4">
                                        {{ $classroom->description }}
                                    </p>
                                @endif

                                {{-- Stats --}}
                                <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        {{ $classroom->participants_count }}/{{ $classroom->max_participants }}
                                    </span>
                                    @if($classroom->duration_minutes)
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $classroom->duration_minutes }} min
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Card Footer --}}
                            <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-3 bg-gray-50 dark:bg-gray-700/50">
                                @if($classroom->status === 'live')
                                    <a href="{{ route('classrooms.room', $classroom) }}" class="block w-full text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
                                        Join Now
                                    </a>
                                @else
                                    <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                                        @if($classroom->scheduled_at)
                                            Starts {{ $classroom->scheduled_at->diffForHumans() }}
                                        @else
                                            Not live
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $classrooms->links() }}
                </div>
            @endif

            {{-- Join by Code (Moved to bottom) --}}
            <div class="mt-12 border-t border-gray-200 dark:border-gray-700 pt-8">
                <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Join a Private Session</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Enter a code if you were invited to a private classroom.</p>
                    <form action="{{ route('classrooms.join-code') }}" method="POST" class="flex gap-3">
                        @csrf
                        <input type="text" name="join_code" placeholder="Enter 8-digit code" maxlength="8" required
                            class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm uppercase"
                            style="text-transform: uppercase;">
                        <button type="submit" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition-colors shadow-sm">
                            Join
                        </button>
                    </form>
                    @error('join_code')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
