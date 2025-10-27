<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kontak: ' . $contact->first_name . ' ' . $contact->last_name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4 border-b pb-2">Informasi Kontak</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                        <p class="text-lg text-gray-900">{{ $contact->first_name }} {{ $contact->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Perusahaan</p>
                        <p class="text-lg text-blue-600 font-semibold">{{ $contact->company->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email</p>
                        <p class="text-lg text-gray-900">{{ $contact->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Jabatan</p>
                        <p class="text-lg text-gray-900">{{ $contact->job_title ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('contacts.edit', $contact) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                        Edit Kontak
                    </a>
                    <a href="{{ route('contacts.index') }}" class="text-gray-600 hover:text-gray-900 ml-4">
                        &larr; Kembali ke Daftar
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold mb-4 border-b pb-2">Catat Interaksi Baru</h3>
                
                <form method="POST" action="{{ route('interactions.store', $contact) }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <x-input-label for="type" :value="__('Tipe Aktivitas')" />
                            <select id="type" name="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="Call">Panggilan Telepon</option>
                                <option value="Email">Email</option>
                                <option value="Meeting">Rapat/Pertemuan</option>
                                <option value="Note">Catatan Internal</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="scheduled_at" :value="__('Tanggal & Waktu Aktivitas')" />
                            <x-text-input id="scheduled_at" name="scheduled_at" type="datetime-local" class="mt-1 block w-full" :value="old('scheduled_at', now()->format('Y-m-d\TH:i'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('scheduled_at')" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="summary" :value="__('Ringkasan / Catatan Aktivitas')" />
                        <textarea id="summary" name="summary" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>{{ old('summary') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('summary')" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Simpan Log') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4 border-b pb-2">Log Interaksi (Aktivitas)</h3>
                
                @if ($interactions->isEmpty())
                    <p class="text-gray-500">Belum ada log interaksi untuk kontak ini.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($interactions as $interaction)
                            <li class="p-3 border rounded-md bg-gray-50">
                                <div class="font-semibold text-gray-800">{{ $interaction->type }} pada {{ \Carbon\Carbon::parse($interaction->scheduled_at)->format('d M Y H:i') }}</div>
                                <p class="text-sm text-gray-600 mt-1">{{ $interaction->summary }}</p>
                                <p class="text-xs text-gray-400 mt-1">Dicatat oleh: {{ $interaction->user->name ?? 'User Tak Dikenal' }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>