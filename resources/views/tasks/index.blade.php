<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Tugas (Tasks)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('tasks.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                        Tambah Tugas Baru
                    </a>

                    <form method="GET" action="{{ route('tasks.index') }}" 
                        class="mb-6 flex space-x-4 items-center" x-data> 
                        
                        {{-- FILTER STATUS --}}
                        <select name="status" 
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                onchange="this.form.submit()"> {{-- KRITIS: Submit saat status diubah --}}
                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Tugas Pending</option>
                            <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Tugas Selesai</option>
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Tugas</option>
                        </select>
                        
                        {{-- PENCARIAN REAL-TIME --}}
                        <input type="text" 
                               name="search" 
                               placeholder="Cari Judul Tugas..." 
                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                               value="{{ $search ?? '' }}"
                               @input.debounce.500ms="$root.submit()">
                        
                        @if ($search || $status != 'pending')
                            <a href="{{ route('tasks.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded shadow-md whitespace-nowrap">
                                Reset Filter
                            </a>
                        @endif
                    </form>
                    @if ($tasks->isEmpty())
                        <p class="mt-4 text-white">Tidak ada tugas yang {{ $status == 'pending' ? 'Pending' : ($status == 'completed' ? 'Selesai' : '') }} saat ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 mt-4">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugas</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($tasks as $task)
                                        <tr class="{{ $task->is_completed ? 'bg-green-50' : '' }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                                                <div class="text-xs text-gray-500">{{ Str::limit($task->description, 50) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                                                {{ $task->contact->first_name ?? 'Umum' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm {{ $task->due_date->isPast() && !$task->is_completed ? 'text-red-500 font-bold' : 'text-gray-900' }}">
                                                {{ $task->due_date->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->is_completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $task->is_completed ? 'Selesai' : 'Pending' }}
                                                </span>
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                
                                                {{-- KRITIS: Gunakan class flex dan justify-between --}}
                                                <div class="flex items-center justify-between"> 
                                                    
                                                    {{-- KELOMPOK KIRI: Edit & Hapus (Aksi Sekunder) --}}
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-600 hover:text-yellow-900 text-xs">Edit</a>
                                                        
                                                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Yakin hapus?');">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="text-red-600 hover:text-red-900 text-xs">Hapus</button>
                                                        </form>
                                                    </div>
                                                    
                                                    {{-- KELOMPOK KANAN: Tombol Status (Aksi Kritis) --}}
                                                    <form method="POST" action="{{ route('tasks.update', $task) }}" class="inline-block">
                                                        @csrf
                                                        @method('patch')
                                                        <input type="hidden" name="toggle_status" value="1"> 
                                                        
                                                        @if (!$task->is_completed)
                                                            <button type="submit" class="text-xs bg-green-500 hover:bg-green-600 text-white py-1 px-2 rounded shadow-sm whitespace-nowrap">
                                                                ✔ Selesai
                                                            </button>
                                                        @else
                                                            <button type="submit" class="text-xs bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-2 rounded shadow-sm whitespace-nowrap">
                                                                ↺ Pending
                                                            </button>
                                                        @endif
                                                    </form>

                                                </div>
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