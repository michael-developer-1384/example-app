<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Participants') }}
            </h2>
            
            <!-- Button zum Erstellen einer neuen Company -->
            <a href="{{ route('participants.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                {{ __('Create New Participants') }}
            </a>
        </div>
    </x-slot>



    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
        @include('components.flash-messages')

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($participants as $participant)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-200 mb-4">{{ $participant->name }}</h3>
                        <p class="text-gray-700 dark:text-gray-400 mb-2">
                            <strong>Address:</strong> 
                        </p>
                        <p class="text-gray-700 dark:text-gray-400 mb-2">
                            <strong>Phone:</strong> 
                        </p>
                        <br>
                        <a href="{{ route('participants.show', $participant) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">View Details</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
