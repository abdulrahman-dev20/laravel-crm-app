<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role; // Import Model Role

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    // Persiapan data untuk setiap test
    protected function setUp(): void
    {
        parent::setUp();
        
        // Pastikan role 'admin' dan 'user' ada sebelum menjalankan test
        Role::findOrCreate('admin');
        Role::findOrCreate('user');
    }

    /** @test */
    public function non_admin_cannot_access_user_management()
    {
        // 1. Buat user biasa tanpa role 'admin'
        $user = User::factory()->create();
        $user->assignRole('user'); // Pastikan dia punya role 'user'

        // 2. Login sebagai user biasa
        $response = $this->actingAs($user)->get('/admin/users');

        // 3. Verifikasi: User harus dialihkan kembali (redirect 302)
        // atau mendapatkan error 403 (Forbidden) karena tidak memiliki role 'admin'
        // Jika Anda tidak mengkonfigurasi redirect, maka 403 adalah default Spatie.
        $response->assertStatus(403); 
        // Jika Anda mengkonfigurasi redirect, gunakan $response->assertRedirect('/home');
    }

    /** @test */
    public function admin_can_access_user_management()
    {
        // 1. Buat user dan berikan role 'admin'
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // 2. Login sebagai admin
        $response = $this->actingAs($admin)->get('/admin/users');

        // 3. Verifikasi: Admin harus mendapatkan status 200 (OK)
        $response->assertStatus(200);
        $response->assertSee('Manajemen User'); // Pastikan teks ini ada di halaman
    }
}