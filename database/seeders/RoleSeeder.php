<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'admin']); // [cite: 555]
        Role::create(['name' => 'editor']); // [cite: 556]
        Role::create(['name' => 'viewer']); // [cite: 557, 560]
    }
}