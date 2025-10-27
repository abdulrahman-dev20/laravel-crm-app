<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter dari request
        $search = $request->get('search');
        $status = $request->get('status', 'pending'); // Default status: pending

       // 1. MULAI DARI MODEL & TERAPKAN LOGIKA ADMIN/USER
        $query = Task::query()
            ->ownedBy(Auth::user()) // <-- INI LOGIKA ADMIN/USER
            ->latest();

        // 2. TERAPKAN LOGIKA PENCARIAN
        if ($search) {
            // Asumsi pencarian Tugas fokus pada nama tugas
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        // 3. (OPSIONAL) LOGIKA FILTER STATUS (Jika Anda punya)
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $tasks = $query->get();

        return view('tasks.index', compact('tasks', 'search', 'status'));
    }

    public function create()
    {
       // KODE BARU: Menggunakan scope OwnedBy untuk memuat data (Contact)
        $contacts = Contact::query()
            ->ownedBy(Auth::user()) // <-- LOGIC ADMIN/USER DISINI
            ->orderBy('first_name')
            ->get();
        
        // Kirimkan ke view
        return view('tasks.create', compact('contacts'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'contact_id' => 'nullable|exists:contacts,id', // Pastikan ID kontak valid (atau null)
        ]);

        // 2. Tambahkan ID yang dibutuhkan
        $validated['user_id'] = Auth::id();
        $validated['is_completed'] = false; // Tugas baru selalu pending

        // 3. Simpan
        Task::create($validated);

        // 4. Redirect ke halaman daftar tugas
        return redirect()->route('tasks.index')
                         ->with('success', 'Tugas baru berhasil ditambahkan!');
    }

    public function update(Request $request, Task $task)
    {
        // PENGAMANAN: Pastikan hanya pemilik yang bisa mengubah
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        // KRITIS: Simpan parameter filter saat ini (status dan search) untuk redirect
        $redirectParams = $request->only(['status', 'search']); 

        // Tentukan apakah kita mengubah status atau mengedit seluruh Task
        if ($request->has('toggle_status')) {
            // Jika ada parameter toggle_status, ubah status is_completed menjadi kebalikannya
            $task->is_completed = !$task->is_completed;
            $task->save();

            $statusMessage = $task->is_completed ? 'selesai' : 'pending';
            
            // REDIRECT BARU: Redirect dengan menyertakan parameter filter yang disimpan
            return redirect()->route('tasks.index', $redirectParams) 
                             ->with('success', 'Status tugas berhasil diubah menjadi ' . $statusMessage . '.');
        }

        // KODE SEMENTARA untuk Edit Task (akan kita lengkapi nanti)
        return redirect()->route('tasks.index', $redirectParams); 
    }
    
    // Kita juga perlu method destroy
    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }


}
