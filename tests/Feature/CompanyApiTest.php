<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company; // Import Model Company
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class CompanyApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup role
        Role::findOrCreate('admin');
        Role::findOrCreate('user');
    }
    
    // =========================================================
    // TEST 1: Akses tanpa token (Unauthorized)
    // =========================================================
    /** @test */
    public function cannot_access_companies_without_api_token()
    {
        // Langsung coba akses endpoint tanpa login atau token
        $response = $this->getJson('/api/companies');

        // Harus mendapatkan status 401 Unauthorized
        $response->assertStatus(401);
    }

    // =========================================================
    // TEST 2: User hanya melihat data yang dimilikinya (Scoped)
    // =========================================================
    /** @test */
    public function regular_user_only_sees_their_own_companies()
    {
        // 1. Setup User 1 (akan jadi user yang login)
        $user1 = User::factory()->create();
        $user1->assignRole('user');
        
        // Buat 1 perusahaan milik User 1
        $company1 = Company::factory()->create(['user_id' => $user1->id]);

        // 2. Setup User 2 (data user lain)
        $user2 = User::factory()->create();
        // Buat 1 perusahaan milik User 2
        $company2 = Company::factory()->create(['user_id' => $user2->id]);

        // 3. Buat token untuk User 1 dan akses API
        $token = $user1->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/companies');

        // 4. Verifikasi
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Hanya ada 1 perusahaan di data
        $response->assertJsonFragment(['name' => $company1->name]); // Memiliki perusahaan User 1
        $response->assertJsonMissing(['name' => $company2->name]); // TIDAK memiliki perusahaan User 2
    }
    
    // =========================================================
    // TEST 3: Admin melihat semua data (Unscoped)
    // =========================================================
    /** @test */
    public function admin_sees_all_companies()
    {
        // 1. Setup Admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        // Buat data dari dua user berbeda
        $company1 = Company::factory()->create(['user_id' => $admin->id]);
        $company2 = Company::factory()->create(['user_id' => User::factory()->create()->id]); // Milik user lain

        // 2. Buat token untuk Admin dan akses API
        $token = $admin->createToken('admin-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/companies');

        // 3. Verifikasi
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // Harus ada 2 perusahaan di data
        $response->assertJsonFragment(['name' => $company1->name]);
        $response->assertJsonFragment(['name' => $company2->name]);
    }
}