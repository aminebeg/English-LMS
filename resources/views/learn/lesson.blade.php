<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    {{ $lesson->title }}
                </h2>
                <div class="text-sm text-gray-500 mt-0.5">
                    {{ $course->title }} &bull; Lesson {{ $lesson->order }}
                </div>
            </div>
            <a href="{{ route('enrollments.show', $course) }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-200 rounded-lg font-semibold text-xs text-gray-600 uppercase tracking-widest shadow-sm hover:bg-gray-50 hover:border-gray-300 transition ease-in-out duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Course
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Lesson Video (if available) -->
                    @if ($lesson->video_url)
                        <div class="bg-black rounded-xl overflow-hidden shadow-lg border border-gray-200">
                            @php
                                $videoUrl = $lesson->video_url;
                                $embedUrl = null;
                                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                                    $embedUrl = "https://www.youtube.com/embed/{$matches[1]}";
                                } elseif (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $videoUrl, $matches)) {
                                    $embedUrl = "https://player.vimeo.com/video/{$matches[1]}";
                                }
                            @endphp
                            @if ($embedUrl)
                                <div class="relative w-full" style="padding-top: 56.25%;">
                                    <iframe src="{{ $embedUrl }}"
                                        class="absolute inset-0 w-full h-full"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            @else
                                <video controls class="w-full rounded-xl bg-gray-900">
                                    <source src="{{ $videoUrl }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    @endif

                    <!-- Lesson Summary (if available) -->
                    @if ($lesson->summary)
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">
                            <h3 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Lesson Summary
                            </h3>
                            <p class="text-blue-800 text-sm leading-relaxed">{{ $lesson->summary }}</p>
                        </div>
                    @endif

                    <!-- Lesson Content -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                        <div class="px-8 py-6 border-b border-gray-100">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $lesson->title }}</h1>
                        </div>
                        <div class="p-8 text-gray-800 prose prose-gray max-w-none">
                            @php
                                $content = $lesson->content;
                                $blocks = [];
                                if (is_string($content)) {
                                    $decoded = json_decode($content, true);
                                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                        $blocks = $decoded;
                                    }
                                }
                            @endphp

                            @if (count($blocks) > 0)
                                @foreach ($blocks as $block)
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
                                            @if ($level === 'h2')
                                                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">{{ $text }}</h2>
                                            @elseif($level === 'h3')
                                                <h3 class="text-xl font-bold text-gray-900 mt-6 mb-3">{{ $text }}</h3>
                                            @else
                                                <h4 class="text-lg font-bold text-gray-900 mt-4 mb-2">{{ $text }}</h4>
                                            @endif
                                        @break

                                        @case('text')
                                            <div class="prose prose-gray max-w-none mb-4">
                                                {!! $data['content'] ?? '' !!}
                                            </div>
                                        @break

                                        @case('image')
                                            @if (!empty($data['src']))
                                                <figure class="my-6">
                                                    <img src="{{ $data['src'] }}"
                                                        alt="{{ $data['caption'] ?? '' }}"
                                                        class="rounded-lg shadow-md w-full">
                                                    @if (!empty($data['caption']))
                                                        <figcaption class="text-sm mt-2 text-center text-gray-500 italic">
                                                            {{ $data['caption'] }}
                                                        </figcaption>
                                                    @endif
                                                </figure>
                                            @endif
                                        @break

                                        @case('video')
                                            @if (!empty($data['src']))
                                                <div class="my-6">
                                                    @php
                                                        $blockVideoUrl = $data['src'];
                                                        $blockEmbedUrl = null;
                                                        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $blockVideoUrl, $matches)) {
                                                            $blockEmbedUrl = "https://www.youtube.com/embed/{$matches[1]}";
                                                        } elseif (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $blockVideoUrl, $matches)) {
                                                            $blockEmbedUrl = "https://player.vimeo.com/video/{$matches[1]}";
                                                        }
                                                    @endphp
                                                    @if ($blockEmbedUrl)
                                                        <div class="aspect-video rounded-lg overflow-hidden border border-gray-200">
                                                            <iframe src="{{ $blockEmbedUrl }}"
                                                                class="w-full h-full"
                                                                frameborder="0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen>
                                                            </iframe>
                                                        </div>
                                                    @else
                                                        <video controls class="w-full rounded-lg">
                                                            <source src="{{ $blockVideoUrl }}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @endif
                                                </div>
                                            @endif
                                        @break

                                        @case('audio')
                                            @if (!empty($data['src']))
                                                <div class="my-6">
                                                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                                                        <div class="flex items-center gap-3 mb-3">
                                                            <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center">
                                                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                                </svg>
                                                            </div>
                                                            <span class="text-sm font-semibold text-gray-900">Audio Content</span>
                                                        </div>
                                                        <audio controls class="w-full">
                                                            <source src="{{ $data['src'] }}" type="audio/mpeg">
                                                            <source src="{{ $data['src'] }}" type="audio/wav">
                                                            <source src="{{ $data['src'] }}" type="audio/ogg">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    </div>
                                                </div>
                                            @endif
                                        @break

                                        @case('code')
                                            <pre class="bg-gray-900 text-gray-100 p-4 rounded-xl overflow-x-auto my-4 text-sm"><code class="language-{{ $data['language'] ?? 'text' }}">{{ $data['code'] ?? '' }}</code></pre>
                                        @break

                                        @case('note')
                                            <div class="flex gap-3 p-4 bg-amber-50 border border-amber-200 rounded-xl my-4">
                                                <div class="flex-shrink-0 mt-0.5">
                                                    <svg class="h-5 w-5 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="text-amber-800 text-sm leading-relaxed">
                                                    {{ $data['content'] ?? '' }}
                                                </div>
                                            </div>
                                        @break

                                        @default
                                            <p class="text-gray-700">{{ $data['content'] ?? '' }}</p>
                                    @endswitch
                                @endforeach
                            @else
                                {{-- Fallback for plain text content --}}
                                {!! nl2br(e($lesson->content)) !!}
                            @endif
                        </div>
                    </div>

                    <!-- Materials / Attachments -->
                    @php
                        $textMaterials  = $materials->where('type', 'text');
                        $videoMaterials = $materials->where('type', 'video');
                        $audioMaterials = $materials->where('type', 'audio');
                        $fileMaterials  = $materials->where('type', 'file');
                    @endphp

                    <!-- Text Materials -->
                    @if ($textMaterials->isNotEmpty())
                        @foreach ($textMaterials as $material)
                            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                                <div class="px-6 py-4 border-b border-gray-100">
                                    <h3 class="text-base font-bold text-gray-900">{{ $material->title }}</h3>
                                </div>
                                <div class="p-6 prose prose-gray max-w-none text-gray-800">
                                    {!! $material->content !!}
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- Video Materials -->
                    @if ($videoMaterials->isNotEmpty())
                        @foreach ($videoMaterials as $material)
                            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                                <div class="p-6">
                                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        {{ $material->title }}
                                    </h3>
                                    @php
                                        $matVideoUrl = $material->content;
                                        $matEmbedUrl = null;
                                        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $matVideoUrl, $matches)) {
                                            $matEmbedUrl = "https://www.youtube.com/embed/{$matches[1]}";
                                        } elseif (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $matVideoUrl, $matches)) {
                                            $matEmbedUrl = "https://player.vimeo.com/video/{$matches[1]}";
                                        }
                                    @endphp
                                    @if ($matEmbedUrl)
                                        <div class="relative w-full rounded-xl overflow-hidden border border-gray-200" style="padding-top: 56.25%;">
                                            <iframe src="{{ $matEmbedUrl }}"
                                                class="absolute inset-0 w-full h-full"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    @else
                                        <video controls class="w-full rounded-xl bg-gray-900">
                                            <source src="{{ $matVideoUrl }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- Audio Materials -->
                    @if ($audioMaterials->isNotEmpty())
                        @foreach ($audioMaterials as $material)
                            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                                <div class="p-6">
                                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                            </svg>
                                        </div>
                                        {{ $material->title }}
                                    </h3>
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                        <audio controls class="w-full">
                                            <source src="{{ $material->content }}" type="audio/mpeg">
                                            <source src="{{ $material->content }}" type="audio/wav">
                                            <source src="{{ $material->content }}" type="audio/ogg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- File Attachments -->
                    @if ($fileMaterials->isNotEmpty())
                        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Download Materials</h3>
                            </div>
                            <div class="p-4 space-y-2">
                                @foreach ($fileMaterials as $material)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors group border border-gray-100">
                                        <div class="flex items-center gap-3 flex-grow min-w-0">
                                            <div class="flex-shrink-0 w-10 h-10 bg-white rounded-lg border border-gray-200 flex items-center justify-center shadow-sm">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0 flex-grow">
                                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $material->title }}</p>
                                                <p class="text-xs text-gray-500">{{ $material->file_name }} &bull; {{ number_format($material->file_size / 1024, 1) }} KB</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('materials.download', $material) }}"
                                            class="flex-shrink-0 ml-3 inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Download
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Navigation & Completion -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                        <div class="p-5 flex items-center justify-between gap-4">
                            @php
                                $prevLesson = $course->lessons
                                    ->where('order', '<', $lesson->order)
                                    ->sortByDesc('order')
                                    ->first();
                                $nextLesson = $course->lessons
                                    ->where('order', '>', $lesson->order)
                                    ->sortBy('order')
                                    ->first();
                            @endphp

                            <!-- Previous Lesson -->
                            <div class="w-1/3">
                                @if ($prevLesson)
                                    <a href="{{ route('learn.lessons.show', $prevLesson) }}"
                                        class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Previous
                                    </a>
                                @endif
                            </div>

                            <!-- Mark Complete Button -->
                            <div class="w-1/3 flex justify-center">
                                <form method="POST"
                                    action="{{ $isCompleted ? route('learn.lessons.incomplete', $lesson) : route('learn.lessons.complete', $lesson) }}">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg font-semibold text-sm transition ease-in-out duration-150 shadow-sm
                                        {{ $isCompleted
                                            ? 'bg-green-50 text-green-700 border border-green-200 hover:bg-green-100'
                                            : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                                        @if ($isCompleted)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
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
                                @if ($nextLesson)
                                    <a href="{{ route('learn.lessons.show', $nextLesson) }}"
                                        class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">
                                        Next
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar: Course Content -->
                <div class="space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200 sticky top-24">
                        <!-- Progress Header -->
                        @php
                            $enrollment = $course->getEnrollmentFor(auth()->user());
                            $progress = $enrollment->progress ?? [];
                            $completedLessons = $progress['completed_lessons'] ?? [];
                            $totalLessons = $course->lessons->count();
                            $completedCount = count(array_intersect($completedLessons, $course->lessons->pluck('id')->toArray()));
                            $progressPercent = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100) : 0;
                        @endphp
                        <div class="px-5 py-4 border-b border-gray-100">
                            <h3 class="text-sm font-bold text-gray-900 mb-2">Course Progress</h3>
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-1.5">
                                <span>{{ $completedCount }} of {{ $totalLessons }} lessons</span>
                                <span class="font-semibold text-indigo-600">{{ $progressPercent }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                <div class="bg-indigo-600 h-1.5 rounded-full transition-all duration-500"
                                    style="width: {{ $progressPercent }}%"></div>
                            </div>
                        </div>

                        <!-- Lesson List -->
                        <div class="max-h-[calc(100vh-300px)] overflow-y-auto">
                            @foreach ($course->lessons->sortBy('order') as $l)
                                @php
                                    $lCompleted = in_array($l->id, $completedLessons);
                                    $isActive = $l->id === $lesson->id;
                                @endphp
                                <a href="{{ route('learn.lessons.show', $l) }}"
                                    class="flex items-center gap-3 px-5 py-3.5 border-b border-gray-50 transition-colors
                                    {{ $isActive ? 'bg-indigo-50 border-l-2 border-l-indigo-500' : 'hover:bg-gray-50' }}">
                                    <div class="flex-shrink-0">
                                        @if ($lCompleted)
                                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shadow-sm">
                                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        @elseif ($isActive)
                                            <div class="w-6 h-6 bg-indigo-600 rounded-full flex items-center justify-center shadow-sm">
                                                <div class="w-2 h-2 bg-white rounded-full"></div>
                                            </div>
                                        @else
                                            <div class="w-6 h-6 border-2 border-gray-200 rounded-full"></div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm truncate {{ $isActive ? 'font-semibold text-indigo-700' : ($lCompleted ? 'text-gray-500' : 'text-gray-700') }}">
                                            {{ $l->order }}. {{ $l->title }}
                                        </p>
                                        @if ($l->duration_minutes)
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $l->duration_minutes }} min</p>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>