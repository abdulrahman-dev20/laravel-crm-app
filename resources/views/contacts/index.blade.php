<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Kontak') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center w-full mb-6"> {{-- Elemen 1: Tombol Tambah Kontak Baru --}}
                        <a href="{{ route('contacts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block whitespace-nowrap">
                            Tambah Kontak Baru
                        </a>

                        {{-- Elemen 2: Form Pencarian --}}
                        <form method="GET" action="{{ route('contacts.index') }}" 
                            class="flex space-x-2 items-center" {{-- UBAH DI SINI: Tambahkan w-full dan max-w-sm agar ada batas lebar --}}
                            x-data>
                            
                            <input type="text" 
                                name="search" 
                                placeholder="Cari Kontak" 
                                {{-- HAPUS: w-full md:w-1/3, karena sudah diatur oleh form dan flex --}}
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm flex-grow" 
                                value="{{ $search ?? '' }}"
                                @input.debounce.500ms="$root.submit()">
                                
                            @if (isset($search) && $search)
                                <a href="{{ route('contacts.index') }}" 
                                class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-2 rounded shadow-md whitespace-nowrap text-sm"> {{-- Sedikit kecilkan padding untuk Reset --}}
                                    Reset
                                </a>
                            @endif
                            <button type="submit" hidden></button>
                        </form>
                    </div>
                    

                    @if ($contacts->isEmpty())
                        <p class="mt-4 text-white">Belum ada data kontak. Silakan tambahkan satu!</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 mt-4">
                                <thead class="bg-gray-100 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perusahaan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200">
                                    @foreach ($contacts as $contact)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $contact->company->name ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $contact->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('contacts.edit', $contact) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Edit</a>
                                                 <a href="{{ route('contacts.show', $contact) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Lihat</a>
                                                <form method="POST" action="{{ route('contacts.destroy', $contact) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontak ini?');">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>