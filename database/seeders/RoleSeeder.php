<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Administrador']);
        $empleado =  Role::create(['name' => 'Empleado']);

        //permiso producto edit

        Permission::create(['name' => 'producto.navbar'])->syncRoles([$admin, $empleado]);
        Permission::create(['name' => 'producto.index'])->syncRoles([$admin, $empleado]);
        Permission::create(['name' => 'producto.create'])->assignRole($admin, );
        Permission::create(['name' => 'producto.edit'])->assignRole($admin, );
        Permission::create(['name' => 'producto.delete'])->assignRole($admin,);
    }
}
