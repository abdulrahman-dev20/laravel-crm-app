<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Utama CRM') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                
                {{-- Bagian Statistik Utama (Grid 3 Kolom) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- KARTU 1: Total Perusahaan --}}
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 border-b-4 border-indigo-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Perusahaan</p>
                                <p class="text-4xl font-bold text-gray-900">{{ $totalCompanies }}</p>
                            </div>
                            <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-9 8h1m-1 4h1m4-4h1m-1 4h1m-9-8h1m-1 4h1"></path></svg>
                        </div>
                    </div>
                    
                    {{-- KARTU 2: Total Kontak --}}
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 border-b-4 border-blue-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Kontak Aktif</p>
                                <p class="text-4xl font-bold text-gray-900">{{ $totalContacts }}</p>
                                <p class="text-xs text-blue-600 mt-1">{{ $newContactsThisMonth }} Kontak Baru Bulan Ini</p>
                            </div>
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20h-2m2 0h-2M2 9h4m-4 0v11m0-11h4m-4 0a2 2 0 110-4h16a2 2 0 110 4M2 9v7l2 2m0 0l-2-2m2 2l2-2m-2 2v-7m0 7l2 2m0 0l-2-2m2 2l2-2m-2 2v-7"></path></svg>
                        </div>
                    </div>
                    
                    {{-- KARTU 3: Tugas Pending --}}
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 border-b-4 border-yellow-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Tugas Pending</p>
                                <p class="text-4xl font-bold text-yellow-700">{{ $totalPendingTasks }}</p>
                                <p class="text-xs text-red-600 mt-1">{{ $overdueTasks }} Tugas Telat Jatuh Tempo!</p>
                            </div>
                            <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7v3m0 0v3m0-3h3m-3 0h-3m3 0z"></path></svg>
                        </div>
                    </div>
                    
                </div>
                
                {{-- Bagian Laporan Tugas (Grid 2 Kolom) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    
                    {{-- KARTU 4: Total Tugas Selesai --}}
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 border-b-4 border-green-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tugas Selesai</p>
                                <p class="text-3xl font-bold text-green-700">{{ $totalCompletedTasks }}</p>
                            </div>
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.617 7.917a4.99 4.99 0 01-1.15 1.15c-1.39 1.39-3.66 1.39-5.05 0a4.99 4.99 0 01-1.15-1.15L3 17.5l4.5-4.5 4.5 4.5 4.5-4.5 4.5 4.5z"></path></svg>
                        </div>
                    </div>
                    
                    {{-- KARTU 5: Total Tugas (Keseluruhan) --}}
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 border-b-4 border-gray-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Semua Tugas</p>
                                <p class="text-3xl font-bold text-gray-700">{{ $totalPendingTasks + $totalCompletedTasks }}</p>
                            </div>
                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>