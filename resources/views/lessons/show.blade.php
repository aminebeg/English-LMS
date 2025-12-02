<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white transition-colors">
                            Courses
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('courses.show', $lesson->course) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white transition-colors">{{ $lesson->course->title }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $lesson->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content Column -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Video Player (if available) -->
                    @if($lesson->video_url)
                        <div class="bg-black rounded-lg overflow-hidden shadow-sm aspect-video border border-gray-200 dark:border-gray-700">
                            <iframe src="{{ str_replace('watch?v=', 'embed/', $lesson->video_url) }}" 
                                class="w-full h-full" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    @endif

                    <!-- Lesson Content -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-8">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="px-2.5 py-0.5 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 text-xs font-bold rounded-full">
                                            Lesson {{ $lesson->order }}
                                        </span>
                                        @if($lesson->difficulty)
                                            <span class="px-2.5 py-0.5 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 text-xs font-bold rounded-full">
                                                {{ ucfirst($lesson->difficulty) }}
                                            </span>
                                        @endif
                                        @if($lesson->duration_minutes)
                                            <span class="px-2.5 py-0.5 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-bold rounded-full flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $lesson->formatted_duration }}
                                            </span>
                                        @endif
                                    </div>
                                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $lesson->title }}</h1>
                                </div>
                                
                                @can('update', $lesson->course)
                                    <div class="flex gap-2">
                                        <a href="{{ route('lessons.edit', $lesson) }}" class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('lessons.destroy', $lesson) }}" onsubmit="return confirm('Delete this lesson?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endcan
                            </div>

                            @if($lesson->summary)
                                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg mb-8 text-gray-700 dark:text-gray-300 italic border-l-4 border-indigo-500">
                                    {{ $lesson->summary }}
                                </div>
                            @endif

                            <!-- Content Rendering -->
                            @php
                                $contentBlocks = json_decode($lesson->content, true);
                                $isBlockContent = json_last_error() === JSON_ERROR_NONE && is_array($contentBlocks);
                            @endphp

                            @if($isBlockContent)
                                <div class="space-y-6 text-gray-900 dark:text-gray-100">
                                    @foreach($contentBlocks as $block)
                                        @switch($block['type'])
                                            @case('heading')
                                                <{{ $block['data']['level'] ?? 'h2' }} class="font-bold text-gray-900 dark:text-white {{ ($block['data']['level'] ?? 'h2') === 'h2' ? 'text-2xl mt-8 mb-4' : (($block['data']['level'] ?? 'h2') === 'h3' ? 'text-xl mt-6 mb-3' : 'text-lg mt-4 mb-2') }}">
                                                    {{ $block['data']['content'] ?? '' }}
                                                </{{ $block['data']['level'] ?? 'h2' }}>
                                                @break

                                            @case('text')
                                                <div class="prose dark:prose-invert max-w-none">
                                                    {!! $block['data']['content'] ?? '' !!}
                                                </div>
                                                @break

                                            @case('image')
                                                <figure class="my-6">
                                                    <img src="{{ $block['data']['src'] ?? '' }}" alt="{{ $block['data']['caption'] ?? '' }}" class="rounded-lg shadow-sm w-full object-cover max-h-[500px]">
                                                    @if(!empty($block['data']['caption']))
                                                        <figcaption class="mt-2 text-center text-sm text-gray-500 dark:text-gray-400 italic">
                                                            {{ $block['data']['caption'] }}
                                                        </figcaption>
                                                    @endif
                                                </figure>
                                                @break

                                            @case('video')
                                                <div class="my-6 aspect-video rounded-lg overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700 bg-black">
                                                    @if(str_contains($block['data']['src'] ?? '', 'youtube.com') || str_contains($block['data']['src'] ?? '', 'youtu.be'))
                                                        <iframe src="{{ str_replace(['watch?v=', 'youtu.be/'], ['embed/', 'www.youtube.com/embed/'], $block['data']['src'] ?? '') }}" 
                                                            class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                                                    @elseif(str_contains($block['data']['src'] ?? '', 'vimeo.com'))
                                                        <iframe src="{{ str_replace('vimeo.com/', 'player.vimeo.com/video/', $block['data']['src'] ?? '') }}" 
                                                            class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                                                    @else
                                                        <video src="{{ $block['data']['src'] ?? '' }}" controls class="w-full h-full"></video>
                                                    @endif
                                                </div>
                                                @break

                                            @case('code')
                                                <div class="my-6 relative group">
                                                    <div class="absolute top-0 right-0 px-2 py-1 text-xs font-mono text-gray-400 bg-gray-800 rounded-bl-md">
                                                        {{ $block['data']['language'] ?? 'text' }}
                                                    </div>
                                                    <pre><code class="language-{{ $block['data']['language'] ?? 'text' }} rounded-lg text-sm">{{ $block['data']['code'] ?? '' }}</code></pre>
                                                </div>
                                                @break

                                            @case('note')
                                                <div class="my-6 flex gap-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 rounded-r-lg">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <div class="prose dark:prose-invert max-w-none text-sm">
                                                        {{ $block['data']['content'] ?? '' }}
                                                    </div>
                                                </div>
                                                @break
                                        @endswitch
                                    @endforeach
                                </div>
                                
                                <!-- Syntax Highlighting -->
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
                                <script>hljs.highlightAll();</script>
                            @else
                                <div class="prose dark:prose-invert max-w-none">
                                    {!! Str::markdown($lesson->content) !!}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Interactive Elements -->
                    @if(($lesson->vocabulary && count($lesson->vocabulary) > 0) || ($lesson->exercises && count($lesson->exercises) > 0))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($lesson->vocabulary && count($lesson->vocabulary) > 0)
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                            <div class="p-1 bg-purple-100 dark:bg-purple-900 rounded">
                                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                            Vocabulary
                                        </h3>
                                    </div>
                                    <div class="p-4 space-y-4">
                                        @foreach($lesson->vocabulary as $item)
                                            <div class="pb-4 border-b border-gray-100 dark:border-gray-700 last:border-0 last:pb-0">
                                                <div class="font-bold text-gray-900 dark:text-white mb-1">{{ $item['word'] }}</div>
                                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $item['definition'] }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($lesson->exercises && count($lesson->exercises) > 0)
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                            <div class="p-1 bg-orange-100 dark:bg-orange-900 rounded">
                                                <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </div>
                                            Practice
                                        </h3>
                                    </div>
                                    <div class="p-4 space-y-4">
                                        @foreach($lesson->exercises as $index => $exercise)
                                            <div class="flex gap-3">
                                                <span class="flex-shrink-0 w-5 h-5 bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300 rounded-full flex items-center justify-center text-xs font-bold">
                                                    {{ $index + 1 }}
                                                </span>
                                                <span class="text-gray-700 dark:text-gray-300 text-sm">{{ $exercise }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Key Points -->
                    @if($lesson->key_points && count($lesson->key_points) > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Key Points
                            </h3>
                            <ul class="space-y-3">
                                @foreach($lesson->key_points as $point)
                                    <li class="flex items-start gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ $point }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Objectives -->
                    @if($lesson->objectives && count($lesson->objectives) > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Learning Objectives
                            </h3>
                            <ul class="space-y-3">
                                @foreach($lesson->objectives as $objective)
                                    <li class="flex items-start gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></span>
                                        {{ $objective }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Resources -->
                    @if($lesson->resources && count($lesson->resources) > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                Resources
                            </h3>
                            <div class="space-y-3">
                                @foreach($lesson->resources as $resource)
                                    <a href="{{ $resource['url'] }}" target="_blank" class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group border border-gray-100 dark:border-gray-600">
                                        <div class="w-8 h-8 bg-white dark:bg-gray-800 rounded-md flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                            <img src="https://www.google.com/s2/favicons?domain={{ parse_url($resource['url'], PHP_URL_HOST) }}" alt="" class="w-4 h-4">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $resource['title'] }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ parse_url($resource['url'], PHP_URL_HOST) }}</div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Teacher Notes (Only visible to tutors) -->
                    @can('update', $lesson->course)
                        @if($lesson->notes)
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg shadow-sm p-6">
                                <h3 class="text-lg font-bold text-yellow-800 dark:text-yellow-200 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                    Teacher's Notes
                                </h3>
                                <p class="text-sm text-yellow-800 dark:text-yellow-200 italic">
                                    {{ $lesson->notes }}
                                </p>
                            </div>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
