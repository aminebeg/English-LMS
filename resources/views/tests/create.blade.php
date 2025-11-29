<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Test to') }} {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('tests.store') }}">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Test Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="passing_score" :value="__('Passing Score (%)')" />
                            <x-text-input id="passing_score" class="block mt-1 w-full" type="number" name="passing_score" :value="old('passing_score', 70)" min="0" max="100" required />
                            <x-input-error :messages="$errors->get('passing_score')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="order" :value="__('Order')" />
                            <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', $course->tests->count() + 1)" required />
                            <x-input-error :messages="$errors->get('order')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('courses.show', $course) }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Cancel
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Create Test') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
