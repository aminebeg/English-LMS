<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-xl text-gray-900 dark:text-white leading-tight">
                    {{ $lesson->title }}
                </h2>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ $course->title }} • Lesson {{ $lesson->order }}
                </div>
            </div>
            <a href="{{ route('enrollments.show', $course) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150">
                Back to Course
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Lesson Content -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="p-8 text-gray-900 dark:text-gray-100 prose dark:prose-invert max-w-none">
                            @php
                                $content = $lesson->content;
                                $blocks = [];
                                
                                // Try to decode as JSON
                                if (is_string($content)) {
                                    $decoded = json_decode($content, true);
                                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                        $blocks = $decoded;
                                    }
                                }
                            @endphp

                            @if(count($blocks) > 0)
                                @foreach($blocks as $block)
                                    @php
                                        $type = $block['type'] ?? 'text';
                                        $data = $block['data'] ?? [];
                                    @endphp

                                    @switch($type)
                                        @case('heading')
                                            @php
                                                $level = $data['level'] ?? 'h2';
                                                $text = $data['content'] ?? '';
                                            @endphp
                                            @if($level === 'h2')
                                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-6 mb-4">{{ $text }}</h2>
                                            @elseif($level === 'h3')
                                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-4 mb-3">{{ $text }}</h3>
                                            @else
                                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mt-3 mb-2">{{ $text }}</h4>
                                            @endif
                                            @break

                                        @case('text')
                                            <div class="prose dark:prose-invert max-w-none mb-4">
                                                {!! $data['content'] ?? '' !!}
                                            </div>
                                            @break

                                        @case('image')
                                            @if(!empty($data['src']))
                                                <figure class="my-6">
                                                    <img src="{{ $data['src'] }}" alt="{{ $data['caption'] ?? '' }}" class="rounded-lg shadow-md w-full">
                                                    @if(!empty($data['caption']))
                                                        <figcaption class="text-sm text-gray-500 dark:text-gray-400 mt-2 text-center">{{ $data['caption'] }}</figcaption>
                                                    @endif
                                                </figure>
                                            @endif
                                            @break

                                        @case('video')
                                            @if(!empty($data['src']))
                                                <div class="my-6">
                                                    @php
                                                        $videoUrl = $data['src'];
                                                        $embedUrl = null;
                                                        
                                                        // YouTube
                                                        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                                                            $embedUrl = "https://www.youtube.com/embed/{$matches[1]}";
                                                        }
                                                        // Vimeo
                                                        elseif (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $videoUrl, $matches)) {
                                                            $embedUrl = "https://player.vimeo.com/video/{$matches[1]}";
                                                        }
                                                    @endphp
                                                    
                                                    @if($embedUrl)
                                                        <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                                                            <iframe src="{{ $embedUrl }}" class="w-full h-96 rounded-lg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                        </div>
                                                    @else
                                                        <video controls class="w-full rounded-lg">
                                                            <source src="{{ $videoUrl }}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @endif
                                                </div>
                                            @endif
                                            @break

                                        @case('code')
                                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto my-4"><code class="language-{{ $data['language'] ?? 'text' }}">{{ $data['code'] ?? '' }}</code></pre>
                                            @break

                                        @case('note')
                                            <div class="flex gap-3 p-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 rounded-r-md my-4">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="text-yellow-800 dark:text-yellow-200">
                                                    {{ $data['content'] ?? '' }}
                                                </div>
                                            </div>
                                            @break

                                        @default
                                            <p>{{ $data['content'] ?? '' }}</p>
                                    @endswitch
                                @endforeach
                            @else
                                {{-- Fallback for plain text content --}}
                                {!! nl2br(e($lesson->content)) !!}
                            @endif
                        </div>
                    </div>

                    <!-- Materials -->
                    @if($materials->isNotEmpty())
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                    Course Materials
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($materials as $material)
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <div class="flex items-center gap-3">
                                                <div class="text-2xl">
                                                    @if($material->type === 'pdf') 📄
                                                    @elseif($material->type === 'video') 🎥
                                                    @elseif($material->type === 'audio') 🎵
                                                    @else 📎
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $material->title }}</h4>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">{{ $material->type }}</p>
                                                </div>
                                            </div>
                                            <a href="{{ $material->url }}" target="_blank" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium">
                                                View
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation & Completion -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="p-6 flex items-center justify-between">
                            <!-- Previous Lesson -->
                            @php
                                $prevLesson = $course->lessons->where('order', '<', $lesson->order)->sortByDesc('order')->first();
                                $nextLesson = $course->lessons->where('order', '>', $lesson->order)->sortBy('order')->first();
                            @endphp

                            <div class="w-1/3">
                                @if($prevLesson)
                                    <a href="{{ route('learn.lessons.show', $prevLesson) }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors font-medium">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                        Previous
                                    </a>
                                @endif
                            </div>

                            <!-- Mark Complete Button -->
                            <div class="w-1/3 flex justify-center">
                                <form method="POST" action="{{ $isCompleted ? route('learn.lessons.incomplete', $lesson) : route('learn.lessons.complete', $lesson) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-md font-semibold text-sm uppercase tracking-widest transition ease-in-out duration-150 shadow-sm {{ $isCompleted ? 'bg-green-100 text-green-800 hover:bg-green-200 border-green-200' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                                        @if($isCompleted)
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Completed
                                        @else
                                            Mark Complete
                                        @endif
                                    </button>
                                </form>
                            </div>

                            <!-- Next Lesson -->
                            <div class="w-1/3 flex justify-end">
                                @if($nextLesson)
                                    <a href="{{ route('learn.lessons.show', $nextLesson) }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors font-medium">
                                        Next
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Course Progress -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 sticky top-24">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Course Content</h3>
                            <div class="space-y-1 max-h-[calc(100vh-300px)] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($course->lessons->sortBy('order') as $l)
                                    @php
                                        $enrollment = $course->getEnrollmentFor(auth()->user());
                                        $progress = $enrollment->progress ?? [];
                                        $lCompleted = in_array($l->id, $progress['completed_lessons'] ?? []);
                                        $isActive = $l->id === $lesson->id;
                                    @endphp
                                    
                                    <a href="{{ route('learn.lessons.show', $l) }}" class="flex items-center p-3 rounded-md transition-colors {{ $isActive ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 font-medium' : 'hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                                        <div class="flex-shrink-0 mr-3">
                                            @if($lCompleted)
                                                <div class="w-5 h-5 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded-full"></div>
                                            @endif
                                        </div>
                                        <span class="text-sm truncate">{{ $l->order }}. {{ $l->title }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
