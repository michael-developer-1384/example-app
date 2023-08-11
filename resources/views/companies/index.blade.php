<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Companies') }}
            </h2>
            
            <!-- Button zum Erstellen einer neuen Company -->
            <a href="{{ route('companies.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                {{ __('Create New Company') }}
            </a>
        </div>
    </x-slot>



    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
        @include('components.flash-messages')

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($companies ?? [] as $company)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-200 mb-4">{{ $company->name }}</h3>
                        <p class="text-gray-700 dark:text-gray-400 mb-2">
                            <strong>Address:</strong> {{ $company->address }}
                        </p>
                        <p class="text-gray-700 dark:text-gray-400 mb-2">
                            <strong>Phone:</strong> {{ $company->phone }}
                        </p>
                        <br>
                        <a href="{{ route('companies.show', $company) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">View Details</a>
                    </div>
                @empty
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-200 mb-4">No companies yet.</h3>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
