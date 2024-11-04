<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\MetodoPago;
use App\Models\Producto;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //Roles y permisos
        $this->call(RoleSeeder::class);

        //crear con factorys
        // User::factory()->create([
        //     'name' => 'Administrador',
        //     'email' => 'admin@gmail.com',
        // ]);

        User::create([
            'name' => 'Cristian Cuellar',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('Administrador');


        User::create([
            'name' => 'Juaquin Chumacero',
            'email' => 'juaquin@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('Empleado');


        //crear cleinte y emtodo de pago
        Cliente::create([
            'nombre' => 'Cliente generico',
            'ci' => 0000,
            'nit' => 0000,
        ]);

        MetodoPago::create([
            'nombre' => 'Efectivo',
        ]);

        MetodoPago::create([
            'nombre' => 'Pago QR',
        ]);






        $this->call(ProductoSeeder::class);


    }
}
