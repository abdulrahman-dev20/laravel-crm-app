<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    /**
     * Menyimpan log Interaksi baru ke database.
     */
    public function store(Request $request, Contact $contact)
    {
        // PENGAMANAN: Pastikan kontak adalah milik user yang sedang login
        if ($contact->user_id !== Auth::id()) {
            abort(403);
        }

        // 1. Validasi
        $validated = $request->validate([
            'type' => 'required|in:Call,Email,Meeting,Note',
            'summary' => 'required|string',
            'scheduled_at' => 'required|date',
        ]);

        // 2. Tambahkan User ID dan Contact ID
        $validated['user_id'] = Auth::id();
        $validated['contact_id'] = $contact->id;

        // 3. Simpan
        $contact->interactions()->create($validated);

        // 4. Redirect kembali ke halaman detail kontak
        return redirect()->route('contacts.show', $contact)
                         ->with('success', 'Log interaksi berhasil ditambahkan!');
    }
}
