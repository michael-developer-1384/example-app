<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Company Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800">
                    <div class="mb-4">
                        <span class="text-lg font-bold text-gray-900 dark:text-gray-200">Name:</span>
                        <span class="text-gray-700 dark:text-gray-400 ml-2">{{ $company->name }}</span>
                    </div>

                    <div class="mb-4">
                        <span class="text-lg font-bold text-gray-900 dark:text-gray-200">Address:</span>
                        <span class="text-gray-700 dark:text-gray-400 ml-2">{{ $company->address }}</span>
                    </div>
                    
                    <div class="mb-4">
                        <span class="text-lg font-bold text-gray-900 dark:text-gray-200">Website:</span>
                        <span class="text-gray-700 dark:text-gray-400 ml-2">{{ $company->website }}</span>
                    </div>

                    <div class="mb-4">
                        <span class="text-lg font-bold text-gray-900 dark:text-gray-200">Phone:</span>
                        <span class="text-gray-700 dark:text-gray-400 ml-2">{{ $company->phone }}</span>
                    </div>

                    
                    <div class="flex items-center gap-4">

                        @if(auth()->user()->companiesWithRole && auth()->user()->companiesWithRole->contains($company->id))
                            <a href="{{ route('companies.edit', $company) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                Edit Company
                            </a>
                        @endif

                        <a href="{{ route('companies.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                            Back
                        </a>
                    </div>

                </div>
            </div>
               
            <div class="mt-8"><br>
                

                <div class="flex justify-between items-center mt-8 mb-4">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-gray-200 mb-4 mt-4">Users</h1>
                    <a href="{{ route('participants.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                        Add Participant
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @forelse ($uniqueUsers as $user)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-200 mb-4">{{ $user->name }}</h3>
                        <p class="text-gray-700 dark:text-gray-400 mb-2">
                            <strong>Email:</strong> {{ $user->email }}
                        </p>
                        @php
                            $roles = $user->rolesInCompany()->wherePivot('company_id', $company->id)->pluck('name')->toArray();
                        @endphp

                        @if(!empty($roles))
                            <p class="text-gray-700 dark:text-gray-400 mb-2">
                                <strong>Roles:</strong> {{ implode(', ', $roles) }}
                            </p>
                        @endif
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg text-center col-span-full">
                        <p class="text-gray-700 dark:text-gray-400">No Users</p>
                    </div>
                @endforelse


                </div>
            </div>
        </div>
     
    </div>

</x-app-layout>
