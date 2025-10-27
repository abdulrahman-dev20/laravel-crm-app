<x-landing>
    {{-- Guest Layout memastikan CSS Tailwind dimuat --}}
    
    <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">

        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between space-x-3">
                <div>
                    <a href="/" class="flex items-center space-x-3">
                        <x-application-logo class="block w-20 h-20 w-auto fill-current text-gray-800 dark:text-gray-200" />
                        <span class="text-2xl font-semibold py-6 text-gray-900 dark:text-white">
                            Dealify
                        </span>
                    </a>
                </div>

                {{-- Navigasi Atas (Login/Register) --}}
                <div class="flex justify-end pt-8">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-black-700 dark:text-gray-500 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline mr-4">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-500 underline ">Register</a>
                        @endif
                    @endauth
                </div>
                
            </div>

            {{-- Konten Utama / Hero Section --}}
            <div class="mt-16 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6 lg:p-10">
                
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
                    {{ config('app.name', 'Laravel') }} CRM Sederhana Anda
                </h1>
                
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                    Kelola kontak, tugas, dan perusahaan Anda dalam satu tempat yang aman dan pribadi. Dibangun dengan kekuatan Laravel dan Tailwind CSS.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div class="p-4 bg-indigo-50 dark:bg-indigo-900 rounded-lg">
                        <h3 class="text-xl font-semibold text-indigo-700 dark:text-indigo-200">Kontak Aman</h3>
                        <p class="text-sm text-indigo-600 dark:text-indigo-400">Semua data terisolasi untuk setiap pengguna. Anda hanya melihat data Anda.</p>
                    </div>
                     <div class="p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                        <h3 class="text-xl font-semibold text-green-700 dark:text-green-200">Task Management</h3>
                        <p class="text-sm text-green-600 dark:text-green-400">Kelola daftar tugas dengan status Pending, Selesai, dan Tanggal Jatuh Tempo.</p>
                    </div>
                     <div class="p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                        <h3 class="text-xl font-semibold text-yellow-700 dark:text-yellow-200">KPI Dashboard</h3>
                        <p class="text-sm text-yellow-600 dark:text-yellow-400">Dapatkan ringkasan statistik perusahaan dan kontak secara instan.</p>
                    </div>
                </div>

                @guest
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Mulai Sekarang (Daftar Gratis)
                    </a>
                @endguest
            </div>
            
            {{-- Footer Sederhana --}}
            <footer class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                Laravel CRM | Dibuat dengan Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </footer>

        </div>
    </div>
</x-landing>