<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //mracar de repuestos de motors
        $marcas = [
           'EXCEL', 'PAI', 'CUMMINS','CATERPILLAR'
        ];
        foreach ($marcas as $m) {
            Marca::create([
                'nombre' => $m
            ]);
        }

        $categorias = [
            ['nombre' => 'Repuesto de motor', 'descripcion' => 'Componentes esenciales y repuestos para el correcto funcionamiento de motores de vehículos y maquinaria.'],
            ['nombre' => 'Ferretería', 'descripcion' => 'Herramientas, materiales y suministros necesarios para proyectos de construcción y mantenimiento.'],
            ['nombre' => 'Pernos', 'descripcion' => 'Sujeciones metálicas diseñadas para ensamblar y asegurar estructuras, piezas o componentes.'],
            ['nombre' => 'Genérico', 'descripcion' => 'Artículos diversos y versátiles que no pertenecen a una categoría específica, útiles en diferentes ámbitos.'],
        ];


        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }


        //productos
        $productos = [
            [
                'codigo_oem' => 'EXC-001',
                'nombre' => 'Bujía de encendido',
                'precio' => 5.00,
                'unidad' => 'unidad',
                'ubicacion' => 'A1',
                'stock' => 100,
                'stock_minimo' => 10,
                'estado' => true,
                'marca_id' => 1,
                'categoria_id' => 1
            ],
            [
                'codigo_oem' => 'PAI-001',
                'nombre' => 'Pistón',
                'precio' => 50.00,
                'unidad' => 'unidad',
                'ubicacion' => 'B2',
                'stock' => 50,
                'stock_minimo' => 5,
                'estado' => true,
                'marca_id' => 2,
                'categoria_id' => 1
            ],
            [
                'codigo_oem' => 'CUM-001',
                'nombre' => 'Filtro de aceite',
                'precio' => 10.00,
                'unidad' => 'unidad',
                'ubicacion' => 'C3',
                'stock' => 200,
                'stock_minimo' => 20,
                'estado' => true,
                'marca_id' => 3,
                'categoria_id' => 1
            ],
            [
                'codigo_oem' => 'CAT-001',
                'nombre' => 'Correa de transmisión',
                'precio' => 30.00,
                'unidad' => 'unidad',
                'ubicacion' => 'D4',
                'stock' => 30,
                'stock_minimo' => 3,
                'estado' => true,
                'marca_id' => 4,
                'categoria_id' => 1
            ],
            [
                'codigo_oem' => 'GEN-001',
                'nombre' => 'Martillo',
                'precio' => 15.00,
                'unidad' => 'unidad',
                'ubicacion' => 'E5',
                'stock' => 20,
                'stock_minimo' => 2,
                'estado' => true,
                'marca_id' => 1,
                'categoria_id' => 2
            ],
            [
                'codigo_oem' => 'GEN-002',
                'nombre' => 'Destornillador',
                'precio' => 5.00,
                'unidad' => 'unidad',
                'ubicacion' => 'F6',
                'stock' => 50,
                'stock_minimo' => 5,
                'estado' => true,
                'marca_id' => 2,
                'categoria_id' => 2
            ],
            [
                'codigo_oem' => 'GEN-003',
                'nombre' => 'Tuerca',
                'precio' => 0.50,
                'unidad' => 'unidad',
                'ubicacion' => 'G7',
                'stock' => 1000,
                'stock_minimo' => 100,
                'estado' => true,
                'marca_id' => 3,
                'categoria_id' => 3
            ],
            [
                'codigo_oem' => 'GEN-004',
                'nombre' => 'Arandela',
                'precio' => 0.25,
                'unidad' => 'unidad',
                'ubicacion' => 'H8',
                'stock' => 2000,
                'stock_minimo' => 200,
                'estado' => true,
                'marca_id' => 4,
                'categoria_id' => 3
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }

    }
}
