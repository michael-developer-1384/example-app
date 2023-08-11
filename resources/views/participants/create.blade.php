<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Participant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form action="{{ route('participants.store') }}" method="post" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                        </div>

                        <div class="mt-4">
                            <span class="text-lg font-medium">Assign to Companies:</span>
                            @foreach (auth()->user()->companies->unique('id') as $company)
                                <div class="mt-2">
                                    <input type="checkbox" name="companies[]" value="{{ $company->id }}" id="company_{{ $company->id }}" checked>
                                    <label for="company_{{ $company->id }}">{{ $company->name }}</label>

                                    <select name="roles[{{ $company->id }}][]" class="ml-2" multiple>
                                        @foreach (\App\Models\Role::all() as $role)
                                            <option value="{{ $role->id }}" {{ $role->name == 'Participant' ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>


                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create Participant') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
