<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\logistic\Gudang;
use App\Models\logistic\Material;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Matrix\Operators\Division;

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
        Role::create([
            'id' => 5,
            'nama_role' => 'ppic',
        ]);
        Role::create([
            'id' => 6,
            'nama_role' => 'purchaser',
        ]);




        User::create([
            'name' => 'adminstd',
            'email' => 'adminstd@gmail.com',
            'password' => '123456789',
            'id_role' => 3
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@logistic.com',
            'password' => '123456789',
            'id_role' => 1
        ]);
        User::create([
            'name' => 'adminrwp',
            'email' => 'adminrwp@gmail.com',
            'password' => '123456789',
            'id_role' => 4
        ]);
        User::create([
            'name' => 'adminplan',
            'email' => 'adminplan@gmail.com',
            'password' => '123456789',
            'id_role' => 2
        ]);
        User::create([
            'name' => 'ppic',
            'email' => 'ppic@gmail.com',
            'password' => '123456789',
            'id_role' => 5
        ]);
        User::create([
            'name' => 'purchaser',
            'email' => 'purchaser@gmail.com',
            'password' => '123456789',
            'id_role' => 6
        ]);

        // seeder logistic

        $this->call(MaterialSeeder::class);
        $this->call(GudangSeeder::class);
        $this->call(RakSeeder::class);
        $this->call(MaterialRakSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(IncomingSeeder::class);
        $this->call(FinishedgoodSeeder::class);



        $this->call(KapasitasSeeder::class);
        $this->call(KategoriProdukSeeder::class);
        $this->call(ProsesSeeder::class);
        $this->call(TipeProsesSeeder::class);
        $this->call(WorkCenterSeeder::class);
        // $this->call(MpsSeeder::class);
        $this->call(ManHourSeeder::class);
        $this->call(DivisionSeeder::class);
        
    }
}
