<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form action="{{ route('companies.update', $company) }}" method="post" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" value="{{ $company->name }}" class="mt-1 block w-full" required autofocus disabled />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" name="address" type="text" value="{{ $company->address }}" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="website" :value="__('Website')" />
                            <x-text-input id="website" name="website" type="url" value="{{ $company->website }}" class="mt-1 block w-full" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" name="phone" type="tel" value="{{ $company->phone }}" class="mt-1 block w-full" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Company') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
