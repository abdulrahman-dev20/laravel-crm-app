<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Perusahaan: ' . $company->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('companies.update', $company) }}">
                        @csrf 
                        @method('patch') <!-- // <-- PENTING: Mengubah method POST menjadi PATCH/PUT -->

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Perusahaan')" />
                            {{-- Menggunakan nilai lama ($company->name) --}}
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $company->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="website" :value="__('Website')" />
                            <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website', $company->website)" />
                            <x-input-error class="mt-2" :messages="$errors->get('website')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="address" :value="__('Alamat')" />
                            {{-- Mengisi nilai textarea dengan nilai lama --}}
                            <textarea id="address" name="address" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">{{ old('address', $company->address) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('companies.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
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