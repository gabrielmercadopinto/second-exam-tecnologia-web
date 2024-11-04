<?php

namespace App\Livewire\Compras;

use App\Models\DetalleCompra;
use App\Models\NotaCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompraCreate extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public $montoTotal = 0;

    public function render()
    {
        return view('livewire.compras.compra-create');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->model(NotaCompra::class)
            ->schema([
                Forms\Components\Section::make('Registrar Compra')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('proveedor_id')
                            ->label('NIT proveedor')
                            ->options(
                                Proveedor::all()->mapWithKeys(function ($provee) {
                                    return [$provee->id => $provee->nit . ' - ' . $provee->nombre];
                                })
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->createOptionForm([
                                Forms\Components\Grid::make('2')
                                    ->schema([
                                        Forms\Components\TextInput::make('nit')
                                        ->label('NIT')
                                        ->numeric()
                                        ->required()
                                        ->minLength(4),
                                        Forms\Components\TextInput::make('ci')
                                            ->label('Carnet de identidad')
                                            ->numeric()
                                            ->minLength(4)
                                            ->maxLength(15),
                                        Forms\Components\TextInput::make('nombre')
                                            ->columnSpan(2)
                                            ->required(),
                                        Forms\Components\TextInput::make('telefono')
                                            ->numeric()
                                            ->integer(),
                                        Forms\Components\TextInput::make('correo')
                                            ->email(),
                                        Forms\Components\TextInput::make('empresa')
                                            ->label('Nombre de la empresa')
                                            ->required(),
                                        Forms\Components\Radio::make('estado')
                                            ->default(1)
                                            ->options([
                                                1 => 'Habilitado',
                                                0 => 'Deshabilitado',
                                            ])
                                ])
                            ])
                            ->createOptionUsing(function (array $data): int {
                                $proveedor = Proveedor::where('nit', $data['nit'])->first();
                                if ($proveedor) {
                                    dd('ya existe');
                                }

                                $proveedor = Proveedor::create([
                                    'nombre' => $data['nombre'],
                                    'nit' => $data['nit'],
                                    'ci' => $data['ci'],
                                ]);
                                // dd($proveedor);
                                return $proveedor->id;
                            })
                            ->CreateOptionModalHeading('Registrar Nuevo Proveedor'),
                        Forms\Components\TextInput::make('nota'),
                        // Forms\Components\Actions\Action::make('createProduct')
                        //     ->action(fn (Forms\Get $get, Forms\Set $set) => $this->createProduct($get, $set)
                        // ),

                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('crear_producto')
                                ->label('Crear Producto')
                                ->icon('heroicon-m-star')
                                ->modal()
                                // ->requiresConfirmation()
                                // ->action(function (Star $star) {
                                //     $star();
                                // })
                                ,
                            ]),

                        Forms\Components\Repeater::make('detalles_compra')
                            // ->label('Detalles de Venta')
                            ->label(false)
                            ->addActionLabel('Agregar Producto')
                            ->minItems(1)
                            ->reorderableWithButtons()
                            ->columnSpan(2)
                            ->afterStateUpdated(function ($state) {

                                $montoTotal = 0;
                                foreach ($state as $s) {
                                    $montoTotal += $s['subtotal'];
                                }
                                // dd('llegmaos', $montoTotal);
                                $montoTotal = number_format($montoTotal, 2, '.', '');
                                $this->montoTotal = $montoTotal;

                            })
                            ->schema([
                            // Grid para organizar los campos en una fila
                            Forms\Components\Grid::make(4) // Definir el grid con 3 columnas
                            ->schema([
                                Forms\Components\Select::make('codigo_producto')
                                    ->label('Código de Producto')
                                    ->options(
                                        Producto::all()->mapWithKeys(function ($producto) {
                                            return [$producto->id => $producto->codigo_oem . ' - ' . $producto->nombre];
                                        })
                                    )
                                    ->searchable()
                                    ->live()
                                    ->reactive()
                                    ->required()
                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => $this->autoCompletarProducto($get, $set)),


                                Forms\Components\TextInput::make('precio')
                                    ->label('Precio')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->reactive()
                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => $this->calculateSubTotal($get, $set)),


                                Forms\Components\TextInput::make('cantidad')
                                    ->label('Cantidad')
                                    ->required()
                                    ->numeric()
                                    ->default(1)
                                    ->integer()
                                    ->reactive()
                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => $this->calculateSubTotal($get, $set)),
                                Forms\Components\TextInput::make('subtotal')
                                    ->label('Sub Total')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->reactive()
                                    ->readOnly(),
                            ])
                        ]),

                        // Forms\Components\TextInput::make('monto_total')
                        //     ->label('Monto Total')
                        //     ->extraAttributes(['style' => 'text-align: right;']) // Alinea el campo a la derecha
                        //     ->disabled(),

                    ]),

            ]);
    }

    public function autoCompletarProducto(Forms\Get $get, Forms\Set $set): void
    {


        if (!$get('codigo_producto')) return;
        $producto = Producto::find($get('codigo_producto'));

        $cantidad = $get('cantidad');
        $subtotal = $producto->precio * $cantidad;
        //reddondear a 2 deciamles, poner cero si es entero
        // $subtotal = round($subtotal, 2);
        // dd($subtotal);

        //redonder y agregar decimales si falta
        $subtotal = number_format($subtotal, 2, '.', '');

        $set('precio', $producto->precio);
        // $set('cantidad', $producto->cantidad);
        $set('subtotal', $subtotal);


        $this->calculoMontoTotal($get, $set);

    }

    public function calculateSubTotal(Forms\Get $get, Forms\Set $set): void
    {
        if (!$get('cantidad') || !$get('precio')) return;
        $cantidad = $get('cantidad');
        $precio = $get('precio');
        $subTotal = $cantidad * $precio;
        // dd($subTotal);
        $set('subtotal', $subTotal);
        $this->calculoMontoTotal($get, $set);
    }

    public function calculoMontoTotal(Forms\Get $get, Forms\Set $set): void
    {
        $montoTotal = 0;
        $productos = $get('../../detalles_compra');

        foreach ($productos as $producto) {
            $montoTotal += $producto['subtotal'];
        }
        // dd('llegmaos', $montoTotal);
        $montoTotal = number_format($montoTotal, 2, '.', '');
        $this->montoTotal = $montoTotal;

    }


    public function create($accion){

        $data = $this->form->getState();
        // dd($data);
         // dd($data);
         try {
            $compra = new NotaCompra();
            //comprasolo poner fecha
            // $compra->fecha  = now('America/La_Paz')->format('Y-m-d');
            // $compra->hota = now('America/La_Paz')->format('H:i:s');
            // $compra->total = $data['total_sin_descuento'];
            $compra->total = $this->montoTotal;
            // $compra->estado = 'pendiente';
            $compra->proveedor_id = $data['proveedor_id']; //en realidad es si id de cliente
            $compra->user_id = Auth::id();
            // $compra->metodo_pago_id = $data['metodo_pago'];
            $compra->save();


            foreach ($data['detalles_compra'] as $detalle) {
                $producto = Producto::where('id', $detalle['codigo_producto'])->first();

                $dv = new DetalleCompra();
                $dv->nota_compra_id = $compra->id;
                $dv->producto_id = $detalle['codigo_producto'];
                $dv->cantidad = $detalle['cantidad'];
                $dv->precio = $detalle['precio'];
                $dv->save();


                $producto->stock += $detalle['cantidad'];
                $producto->save();

            }

                Notification::make()
                    ->title('Compra Registrada con Exito!!')
                    ->success()
                    ->body("La compra Nro: {$compra->id} se ha registrado correctamente")
                    ->send();

            if ($accion == 'create') {
                $this->reset();
                $this->form->fill();
                // $this->emit('scrollToTop');
                $this->dispatch('scrollToTop');
                return;
            }else{
                return redirect()->route('compra.index');
            }
        } catch (\Exception $e) {
            dd($e);
        }

    }


    public function cancelar()
    {
        // Simplemente redirige a la lista de ventas sin hacer nada
        return redirect()->route('compra.index');
    }

}
