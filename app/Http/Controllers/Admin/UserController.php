<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Ambil SEMUA user yang terdaftar
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        // Ambil semua role yang ada di database (admin, user)
        $roles = Role::pluck('name', 'name'); 
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // 1. Validasi Input: Pastikan 'role' ada dan merupakan string
        $request->validate([
            'role' => ['required', 'string', 'exists:roles,name'], 
        ]);

        // 2. Hapus Semua Role Lama (Penting! Agar user tidak punya 2 role)
        // Note: Asumsi kita hanya mengizinkan 1 role per user (Admin atau User Biasa).
        $user->syncRoles([]); 

        // 3. Tetapkan Role Baru
        $user->assignRole($request->role);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('admin.users.index')
                         ->with('success', 'Role untuk ' . $user->name . ' berhasil diperbarui menjadi ' . ucwords($request->role) . '.');
    }
}