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

                        <!-- Participant Details -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                        </div>

                        <div class="flex items-center gap-4">
                            <input type="checkbox" id="must_change_password" name="must_change_password" value="1">
                            <x-input-label for="must_change_password" :value="__('Force password change on first login?')" />
                        </div>

                        <!-- Companies and Roles -->
                        @foreach (auth()->user()->companiesWithRole->unique('id') as $company)
                            <div class="bg-gray-100 p-4 my-4 rounded">
                                <div class="flex justify-between items-center company-header" style="cursor: default;">
                                    <div class="flex items-center">
                                    <input type="checkbox" name="companies[]" value="{{ $company->id }}" id="company_{{ $company->id }}" {{ $selectedCompany == $company->id ? 'checked' : '' }} onchange="toggleCompanyRoles({{ $company->id }})">
                                    <span class="text-xl ml-2">{{ $company->name }}</span>
                                    </div>
                                </div>

                                <div class="mt-2 company-roles" id="roles_for_company_{{ $company->id }}">
                                    <hr><br>
                                    @foreach (\App\Models\Role::all() as $role)
                                        <label class="mr-4 inline-flex items-center">
                                            <input type="checkbox" name="roles[{{ $company->id }}][]" value="{{ $role->id }}" {{ $role->name == 'Participant' ? 'checked' : '' }}>
                                            <span class="ml-2">{{ $role->name }}</span>
                                        </label><br>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach


                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create Participant') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function toggleCompanyRoles(companyId) {
            const isChecked = document.getElementById(`company_${companyId}`).checked;
            const rolesDiv = document.getElementById(`roles_for_company_${companyId}`);
            const checkboxes = rolesDiv.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(checkbox => {
                checkbox.disabled = !isChecked;
            });

            // Toggle visibility based on the checkbox state
            rolesDiv.style.display = isChecked ? 'block' : 'none';
        }

        // Initial setup
        document.addEventListener('DOMContentLoaded', () => {
            @foreach (auth()->user()->companiesWithRole->unique('id') as $company)
                toggleCompanyRoles({{ $company->id }});
            @endforeach
        });


        document.querySelectorAll('.company-header').forEach(header => {
            header.addEventListener('click', function() {
                const checkbox = this.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;
                toggleCompanyRoles(checkbox.value);
            });
        });

    </script>
</x-app-layout>
