<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Tugas Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf 

                        <div class="mb-4">
                            <x-input-label for="contact_id" :value="__('Terkait Kontak')" />
                            <select id="contact_id" name="contact_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">-- Tugas Umum (Tidak Terkait Kontak) --</option>
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->id }}" {{ old('contact_id') == $contact->id ? 'selected' : '' }}>
                                        {{ $contact->first_name }} {{ $contact->last_name }} ({{ $contact->company->name ?? 'Tanpa Perusahaan' }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('contact_id')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Judul Tugas')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="due_date" :value="__('Jatuh Tempo Tugas')" />
                            <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full" :value="old('due_date', Carbon\Carbon::tomorrow()->format('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi Tambahan (Opsional)')" />
                            <textarea id="description" name="description" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Tugas') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>