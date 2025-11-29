<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Pending Tutors</h3>
                    @if($pendingTutors->isEmpty())
                        <p>No pending tutors.</p>
                    @else
                        <ul>
                            @foreach($pendingTutors as $tutor)
                                <li class="flex justify-between items-center mb-2 border-b pb-2">
                                    <span>{{ $tutor->name }} ({{ $tutor->email }})</span>
                                    <form method="POST" action="{{ route('editor.approve', $tutor) }}">
                                        @csrf
                                        <x-primary-button>Approve</x-primary-button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
