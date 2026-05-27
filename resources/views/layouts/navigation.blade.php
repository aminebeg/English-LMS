<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900 text-base tracking-tight">EnglishLMS</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:ms-8 sm:flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                        {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        Dashboard
                    </a>

                    @if(Auth::user()->hasRole('student'))
                        <a href="{{ route('courses.browse') }}"
                            class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                            {{ request()->routeIs('courses.browse') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            Browse Courses
                        </a>
                        <a href="{{ route('enrollments.index') }}"
                            class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                            {{ request()->routeIs('enrollments.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            My Courses
                        </a>
                        <a href="{{ route('tests.my-results') }}"
                            class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                            {{ request()->routeIs('tests.my-results') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            Test Results
                        </a>
                    @endif

                    @if(Auth::user()->hasRole('tutor'))
                        <a href="{{ route('courses.index') }}"
                            class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                            {{ request()->routeIs('courses.*') || request()->routeIs('lessons.*') || request()->routeIs('materials.*') || request()->routeIs('tests.*') || request()->routeIs('questions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            My Courses
                        </a>
                        <a href="{{ route('courses.create') }}"
                            class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                            {{ request()->routeIs('courses.create') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            + New Course
                        </a>
                    @endif

                    @if(Auth::user()->hasRole('editor'))
                        <a href="{{ route('editor.dashboard') }}"
                            class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                            {{ request()->routeIs('editor.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            Editor Panel
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <!-- Role badge -->
                @if(Auth::user()->hasRole('tutor'))
                    <span class="px-2.5 py-1 text-xs font-semibold bg-purple-100 text-purple-700 rounded-full">Tutor</span>
                @elseif(Auth::user()->hasRole('student'))
                    <span class="px-2.5 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">Student</span>
                @elseif(Auth::user()->hasRole('editor'))
                    <span class="px-2.5 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Editor</span>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="w-7 h-7 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="fill-current h-3.5 w-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-xs text-gray-500">Signed in as</p>
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-0.5 px-3">
            <a href="{{ route('dashboard') }}"
                class="block px-3 py-2.5 rounded-md text-sm font-medium transition-colors
                {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                Dashboard
            </a>

            @if(Auth::user()->hasRole('student'))
                <a href="{{ route('courses.browse') }}"
                    class="block px-3 py-2.5 rounded-md text-sm font-medium transition-colors
                    {{ request()->routeIs('courses.browse') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                    Browse Courses
                </a>
                <a href="{{ route('enrollments.index') }}"
                    class="block px-3 py-2.5 rounded-md text-sm font-medium transition-colors
                    {{ request()->routeIs('enrollments.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                    My Courses
                </a>
                <a href="{{ route('tests.my-results') }}"
                    class="block px-3 py-2.5 rounded-md text-sm font-medium transition-colors
                    {{ request()->routeIs('tests.my-results') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                    Test Results
                </a>
            @endif

            @if(Auth::user()->hasRole('tutor'))
                <a href="{{ route('courses.index') }}"
                    class="block px-3 py-2.5 rounded-md text-sm font-medium transition-colors
                    {{ request()->routeIs('courses.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                    My Courses
                </a>
                <a href="{{ route('courses.create') }}"
                    class="block px-3 py-2.5 rounded-md text-sm font-medium transition-colors
                    {{ request()->routeIs('courses.create') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                    + New Course
                </a>
            @endif

            @if(Auth::user()->hasRole('editor'))
                <a href="{{ route('editor.dashboard') }}"
                    class="block px-3 py-2.5 rounded-md text-sm font-medium transition-colors
                    {{ request()->routeIs('editor.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                    Editor Panel
                </a>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-gray-100 px-3">
            <div class="flex items-center gap-3 px-3 mb-3">
                <div class="w-9 h-9 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-semibold text-sm text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-0.5">
                <a href="{{ route('profile.edit') }}"
                    class="block px-3 py-2.5 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                    Profile
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="w-full text-left px-3 py-2.5 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
