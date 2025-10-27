<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Perusahaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Blok Kontrol: Tombol Tambah & Form Pencarian (TIDAK DIGANTI) --}}
                    <div class="flex justify-between items-center w-full mb-6"> 
                        <a href="{{ route('companies.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block whitespace-nowrap">
                            Tambah Perusahaan Baru
                        </a>

                        {{-- Catatan: Saya ubah route kontak ke companies untuk konsistensi --}}
                        <form method="GET" action="{{ route('companies.index') }}" 
                            class="flex space-x-2 items-center" 
                            x-data>
                            
                            <input type="text" 
                                name="search" 
                                placeholder="Cari Perusahaan" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm flex-grow" 
                                value="{{ $search ?? '' }}"
                                @input.debounce.500ms="$root.submit()">
                                
                            @if (isset($search) && $search)
                                <a href="{{ route('companies.index') }}" 
                                class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-2 rounded shadow-md whitespace-nowrap text-sm"> 
                                    Reset
                                </a>
                            @endif
                            <button type="submit" hidden></button>
                        </form>
                    </div>

                    {{-- ========================================================== --}}
                    {{-- BLOK UTAMA YANG DIGANTI: Panggil Component Tabel Baru --}}
                    {{-- ========================================================== --}}
                    
                    {{-- Kita panggil component yang dibuat di Langkah 11-13 --}}
                    <x-data-tables.company-table :companies="$companies" />
                    
                    {{-- Jika Anda menggunakan pagination, tambahkan link pagination di bawah component --}}
                    @if ($companies instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-4">
                            {{ $companies->links() }}
                        </div>
                    @endif

                    {{-- Catatan: Logic isEmpty() kini ada di dalam Component company-table.blade.php --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>