<?php
// database/factories/CompanyFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Tambahkan field 'name'
            'name' => $this->faker->company(), 
            
            // Tambahkan field user_id, jika diperlukan oleh model Company
            // Biasanya CompanyFactory tidak tahu siapa user-nya, tapi tes kita menyediakannya.
            // Biarkan kosong di sini jika tes akan menimpanya.
        ];
    }
}