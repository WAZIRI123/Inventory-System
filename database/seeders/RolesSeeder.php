<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'super-admin']);
        $role = Role::create(['name' => 'Admin']);
        $role = Role::create(['name' => 'Mpishi']);
        $role = Role::create(['name' => 'Muuzaji']);
    }
}
