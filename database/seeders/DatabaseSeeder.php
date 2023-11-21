<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\logistic\Material;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        Role::create([
            'id' => 1,
            'nama_role' => 'logistic',
        ]);
        Role::create([
            'id' => 2,
            'nama_role' => 'planer',
        ]);
        Role::create([
            'id' => 3,
            'nama_role' => 'standardized_work',
        ]);
        Role::create([
            'id' => 4,
            'nama_role' => 'resource_work_planning',
        ]);
        User::create([
            'name' => 'widia',
            'email' => 'widia@std.com',
            'password' => '123456789',
            'id_role' => 1
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@logistic.com',
            'password' => '123456789',
            'id_role' => 1
        ]);
        User::create([
            'name' => 'andi',
            'email' => 'andi@std.com',
            'password' => '123456789',
            'id_role' => 2
        ]);


        $this->call(KapasitasSeeder::class);
        $this->call(KategoriProdukSeeder::class);
        $this->call(ProsesSeeder::class);
        $this->call(TipeProsesSeeder::class);
        $this->call(WorkCenterSeeder::class);
        $this->call(ManHourSeeder::class);
    }
}
