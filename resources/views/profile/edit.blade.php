<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                    Profile Settings
                </h1>
                <p class="text-gray-600 dark:text-gray-400">Manage your account information and security</p>
            </div>

            <div class="space-y-8">
                <!-- Profile Information -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                    <div class="p-8">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <!-- Update Password -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="h-2 bg-gradient-to-r from-purple-500 to-pink-500"></div>
                    <div class="p-8">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
                    <div class="p-8">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
