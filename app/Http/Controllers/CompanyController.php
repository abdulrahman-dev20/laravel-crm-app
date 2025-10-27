<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
   /**
     * Menampilkan daftar sumber daya (Daftar Perusahaan)
     */
     public function index(Request $request) // Tambahkan Request $request
    {
        // Ambil string pencarian dari URL
        $search = $request->get('search'); 

        // Mulai query dari Model Company, LALU terapkan scope OwnedBy
        $query = Company::query()
            ->ownedBy(Auth::user()) // <-- ADMIN/USER LOGIC BERJALAN DI SINI
            ->latest();

        // JIKA ada string pencarian, tambahkan kondisi WHERE
        if ($search) {
            // Karena ownedBy sudah terapkan filter user_id jika bukan admin, 
            // kita perlu menggunakan where biasa untuk filter pencarian:
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%') // Cari berdasarkan nama perusahaan
                ->orWhere('website', 'like', '%' . $search . '%'); // Atau berdasarkan website
            });
        }

        // Eksekusi query
        $companies = $query->paginate(10);

        // Kirimkan juga string pencarian ke view agar input field tetap terisi
        return view('companies.index', compact('companies', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // Langsung tampilkan view untuk form tambah data
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name', // Nama harus unik
            'website' => 'nullable|url|max:255',
            'phone_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'industry' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        // 2. Tambahkan user_id dari user yang sedang login
        $validated['user_id'] = auth()->id();

        // 3. Simpan ke Database
        Company::create($validated);

        // 4. Redirect kembali ke halaman daftar perusahaan dengan pesan sukses
        return redirect()->route('companies.index')
                         ->with('success', 'Perusahaan berhasil ditambahkan!');
    }

    public function show(Company $company)
    {
        // PENTING: Pengamanan agar hanya user pemilik data yang bisa melihat
        if ($company->user_id !== auth()->id()) {
            abort(403); // Tampilkan error 403 (Unauthorized)
        }

        // Tampilkan view detail perusahaan
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company) // Laravel otomatis mencari Company berdasarkan ID di URL
    {
        // Pastikan hanya pemilik data yang bisa mengedit
        if ($company->user_id !== auth()->id()) {
            abort(403); // Unauthorized access
        }

        return view('companies.edit', compact('company'));
    }

    /**
     * Memperbarui sumber daya tertentu di storage.
     */
    public function update(Request $request, Company $company)
    {
        // 1. Pastikan hanya pemilik data yang bisa mengupdate
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }

        // 2. Validasi Data
        // PENTING: Pada validasi 'unique', kita harus mengabaikan ID company yang sedang diedit
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $company->id, 
            'website' => 'nullable|url|max:255',
            'phone_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'industry' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        // 3. Simpan perubahan ke Database
        $company->update($validated);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->route('companies.index')
                         ->with('success', 'Perusahaan berhasil diperbarui!');
    }

    /**
     * Menghapus sumber daya tertentu dari storage.
     */
    public function destroy(Company $company)
    {
        // 1. Pastikan hanya pemilik data yang bisa menghapus
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }

        // 2. Hapus dari Database
        $company->delete();

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('companies.index')
                         ->with('success', 'Perusahaan berhasil dihapus!');
    }
}
