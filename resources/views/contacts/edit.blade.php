<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kontak: ' . $contact->first_name . ' ' . $contact->last_name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('contacts.update', $contact) }}">
                        @csrf 
                        @method('patch') 

                        <div class="mb-4">
                            <x-input-label for="company_id" :value="__('Perusahaan')" />
                            <select id="company_id" name="company_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="">-- Pilih Perusahaan --</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" 
                                            {{ old('company_id', $contact->company_id) == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('company_id')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="first_name" :value="__('Nama Depan')" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $contact->first_name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="last_name" :value="__('Nama Belakang')" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $contact->last_name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $contact->email)" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="job_title" :value="__('Jabatan')" />
                            <!-- {{-- Di Create.blade.php gunakan old('job_title') --}} -->
                            <x-text-input id="job_title" name="job_title" type="text" class="mt-1 block w-full" :value="old('job_title', $contact->job_title)" />
                            <x-input-error class="mt-2" :messages="$errors->get('job_title')" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('contacts.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>