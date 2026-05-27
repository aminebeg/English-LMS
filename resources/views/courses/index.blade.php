<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="sm:flex sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">My Courses</h1>
                    <p class="mt-1 text-sm text-gray-500">Manage and monitor all the courses you are teaching.</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('courses.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-sm transition-colors shadow-sm">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Create Course
                    </a>
                </div>
            </div>

            @if ($courses->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">No courses yet</h3>
                    <p class="text-sm text-gray-500 mb-6">Get started by creating your first course.</p>
                    <a href="{{ route('courses.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-sm transition-colors shadow-sm">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Create Your First Course
                    </a>
                </div>
            @else
                <!-- Courses Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50">
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Course
                                </th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Content
                                </th>
                                <th scope="col" class="relative px-6 py-3.5">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($courses as $course)
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 h-12 w-20 bg-indigo-100 rounded-lg overflow-hidden">
                                                @if ($course->thumbnail)
                                                    <img class="h-12 w-20 object-cover"
                                                        src="{{ Storage::url($course->thumbnail) }}"
                                                        alt="">
                                                @else
                                                    <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-indigo-400 to-indigo-600">
                                                        <svg class="h-5 w-5 text-white opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $course->title }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5">{{ $course->category ?? 'Uncategorized' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1.5">
                                            @if ($course->is_published)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 w-fit">
                                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                                    Published
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 w-fit">
                                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span>
                                                    Draft
                                                </span>
                                            @endif
                                            @if ($course->is_featured)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 w-fit">
                                                    ★ Featured
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900">
                                            @if ($course->price == 0)
                                                <span class="text-emerald-600">Free</span>
                                            @else
                                                ${{ number_format($course->final_price, 2) }}
                                            @endif
                                        </div>
                                        @if ($course->discount_percentage > 0)
                                            <div class="text-xs text-red-500 mt-0.5">
                                                {{ $course->discount_percentage }}% Off
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700">
                                            <span class="font-semibold">{{ $course->lessons->count() }}</span>
                                            <span class="text-gray-500"> lessons</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-3 opacity-60 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('courses.show', $course) }}"
                                                class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                                                View
                                            </a>
                                            <span class="text-gray-200">|</span>
                                            <a href="{{ route('courses.edit', $course) }}"
                                                class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
