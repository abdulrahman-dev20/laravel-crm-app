<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // KRITIS: Tambahkan Request $request
    {
        $search = $request->get('search'); 

       // 1. MULAI DARI MODEL & TERAPKAN LOGIKA ADMIN/USER
        $query = Contact::query()
            ->ownedBy(Auth::user()) // <-- INI LOGIKA ADMIN/USER
            ->latest();

        // 2. TERAPKAN LOGIKA PENCARIAN
        if ($search) {
            // Menggunakan field yang umum untuk pencarian Kontak
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%') 
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $contacts = $query->get();

        return view('contacts.index', compact('contacts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil SEMUA perusahaan milik user yang sedang login untuk dropdown
        $companies = Auth::user()
            ->companies()
            ->select('id', 'name') // Hanya ambil ID dan Nama
            ->orderBy('name')
            ->get();
            
        // Jika user belum punya perusahaan, arahkan untuk buat perusahaan dulu
        if ($companies->isEmpty()) {
            return redirect()->route('companies.create')
                             ->with('error', 'Anda harus membuat perusahaan terlebih dahulu sebelum menambahkan kontak.');
        }

        return view('contacts.create', compact('companies'));
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id', // Harus ada dan ID-nya valid di tabel companies
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:contacts,email', // Email harus unik
            'phone_number' => 'nullable|string|max:50',
            'job_title' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'is_customer' => 'nullable|boolean', // Diabaikan dulu untuk simplicity
            'notes' => 'nullable|string',
        ]);

        // 2. Tambahkan user_id dari user yang sedang login
        $validated['user_id'] = auth()->id();

        // 3. Simpan ke Database
        Contact::create($validated);

        // 4. Redirect kembali ke halaman daftar kontak dengan pesan sukses
        return redirect()->route('contacts.index')
                         ->with('success', 'Kontak berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        // PENGAMANAN: Pastikan hanya pemilik data yang bisa melihat
        if ($contact->user_id !== auth()->id()) {
            abort(403); 
        }

        // Ambil semua interaksi yang terkait dengan kontak ini
        $interactions = $contact->interactions()
            ->with('user') // Ambil juga siapa user yang membuat log interaksi (opsional)
            ->latest()
            ->get();

        return view('contacts.show', compact('contact', 'interactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        // PENGAMANAN: Hanya pemilik data yang boleh mengedit
        if ($contact->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Ambil kembali daftar perusahaan untuk dropdown
        $companies = Auth::user()
            ->companies()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('contacts.edit', compact('contact', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        // PENGAMANAN: Hanya pemilik data yang boleh update
        if ($contact->user_id !== auth()->id()) {
            abort(403);
        }

        // 1. Validasi Data
        // PENTING: Abaikan email kontak yang sedang diedit agar validasi 'unique' tidak error
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:contacts,email,' . $contact->id, 
            'phone_number' => 'nullable|string|max:50',
            'job_title' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        // 2. Simpan perubahan ke Database
        $contact->update($validated);

        // 3. Redirect kembali
        return redirect()->route('contacts.index')
                         ->with('success', 'Kontak berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        // PENGAMANAN: Hanya pemilik data yang boleh menghapus
        if ($contact->user_id !== auth()->id()) {
            abort(403);
        }

        $contact->delete();

        return redirect()->route('contacts.index')
                         ->with('success', 'Kontak berhasil dihapus!');
    }
}
