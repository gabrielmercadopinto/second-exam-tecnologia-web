<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\VentaController;
use App\Livewire\ClienteIndex;
use App\Livewire\ListEmpleado;
use App\Livewire\ListProveedor;
use App\Livewire\Rols\RolCreate;
use App\Models\NotaVenta;
use Illuminate\Support\Facades\Route;

Route::get('/prueba', function () {


    $m = new \App\Models\MetodoPago();
    $m->nombre = 'Efectivo';
    $m->save();

    $v = NotaVenta::create([
        'cliente_id' => 1,
        'metodo_pago_id' => $m->id,
        'total' => 100,
        'fecha' => now(),
        'estado' => 'pendiente'
    ]);


    dd( $v );

    return 'xzxd';
});

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/roles', [RolesController::class, 'index'])->name('rol.index');


    //llamar a livewire
    Route::get('/roles/create', RolCreate::class)->name('rol.create');
    Route::get('/clientes', ClienteIndex::class)->name('cliente.index');

    Route::get('/empleados', ListEmpleado::class)->name('empleado.index');
    Route::get('/proveedor', ListProveedor::class)->name('proveedor.index');

    Route::get('/productos', [ProductoController::class, 'index'])->name('producto.index');
    Route::resource('/ventas', VentaController::class)->names('venta');
    // Route::get('/ventas', [VentaController::class, 'index'])->name('producto.index');
    Route::resource('/cotizaciones', CotizacionController::class)
        ->names('cotizacion')
        //poner el id que recibira en la url
        ->parameters(['cotizaciones' => 'cotizacion']);

    Route::resource('/compras', CompraController::class)->names('compra');

    Route::get('/productos/marcas', [ProductoController::class, 'marca_index'])->name('producto.marca');



    Route::get('/reportes', function () {
        dd('en desarrollo');
        // return view('reportes.index');
    })->name('reportes.index');

});

require __DIR__.'/auth.php';
