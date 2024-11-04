<?php

namespace App\Livewire\Cotizaciones;

use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Models\Producto;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CotizacionesCreate extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public $montoTotal = 0;

    public function render()
    {
        return view('livewire.cotizaciones.cotizaciones-create');
    }

    public function mount(): void
    {
        $this->form->fill();
    }


    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->model(Cotizacion::class)
            ->schema([
                Forms\Components\Grid::make(4) // Grid de 2 columnas
                    ->schema([
                        Forms\Components\Section::make('Registrar Cotizacion')
                            ->columnSpan(3)
                            ->columns(4)
                            ->schema([
                                Forms\Components\Repeater::make('detalles_venta')
                                    // ->label('Detalles de Venta')
                                    ->label(false)
                                    ->addActionLabel('Agregar Producto')
                                    ->minItems(1)
                                    ->reorderableWithButtons()
                                    ->columnSpan(4)
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
                                        Forms\Components\Grid::make(5) // Definir el grid con 3 columnas
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
                                                    ->columnSpan(2)
                                                    ->placeholder('Buscar...')
                                                    ->reactive()
                                                    ->required()
                                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => $this->autoCompletarProducto($get, $set)),


                                                Forms\Components\TextInput::make('precio')
                                                    ->label('Precio')
                                                    ->required()
                                                    ->numeric()
                                                    ->default(0)
                                                    ->reactive()
                                                    ->extraInputAttributes([
                                                        'style' =>  '
                                                            text-align: right;
                                                            '
                                                        ])
                                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => $this->calculateSubTotal($get, $set)),


                                                Forms\Components\TextInput::make('cantidad')
                                                    ->label('Cantidad')
                                                    ->required()
                                                    ->numeric()
                                                    ->default(1)
                                                    ->integer()
                                                    ->reactive()
                                                    ->extraInputAttributes([ 'style' =>  ' text-align: right;'  ])
                                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => $this->calculateSubTotal($get, $set)),
                                                Forms\Components\TextInput::make('subtotal')
                                                    ->label('Sub Total')
                                                    ->required()
                                                    ->numeric()
                                                    ->default(0)
                                                    ->reactive()
                                                    ->extraInputAttributes([ 'style' =>  ' text-align: right;'  ])
                                                    ->readOnly(),
                                            ]),
                                    ]),
                                Forms\Components\Grid::make(4)
                                    ->schema([
                                        Forms\Components\Placeholder::make('monto_total_text')
                                        ->label(false)
                                        // ->content('Monto Total: $:')
                                        ->content(fn () => "Monto Total: " . $this->montoTotal . " Bs")
                                        ->columnSpan('full')
                                        ->extraAttributes([
                                            'style' => '
                                                text-align:right;
                                                font-weight: 500;
                                                font-size: 1.25rem;
                                                '
                                        ]),
                                    ]),

                            ]),
                        Forms\Components\Section::make('Registrar Cliente')
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\Select::make('cliente_id')
                                    ->label('CI del Cliente')
                                    ->options(
                                        Cliente::all()->mapWithKeys(function ($cliente) {
                                            return [$cliente->id => $cliente->nit . ' - ' . $cliente->nombre];
                                        })
                                    )
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->placeholder('Buscar...')
                                    ->createOptionForm([
                                        Forms\Components\Grid::make('2')
                                            ->schema([
                                                Forms\Components\TextInput::make('ci')
                                                    ->label('Carnet de identidad')
                                                    ->required()
                                                    ->numeric()
                                                    ->minLength(4)
                                                    ->maxLength(15),
                                                Forms\Components\TextInput::make('nit')
                                                    ->label('NIT')
                                                    ->numeric()
                                                    ->minLength(4)
                                                    ->maxLength(15),
                                                Forms\Components\TextInput::make('nombre')
                                                    ->required(),
                                            ])
                                    ])
                                    ->createOptionUsing(function (array $data): int {
                                        //validar que no exista el cliente
                                        $cliente = Cliente::where('ci', $data['ci'])->first();
                                        if ($cliente) {
                                            //mostrar mensaje de error
                                            dd('ya existe');
                                            // return $cliente->ci;
                                        }

                                        $cliente = Cliente::create([
                                            'ci' => $data['ci'],
                                            'nit' => $data['nit'],
                                            'nombre' => $data['nombre'],
                                        ]);
                                        return $cliente->id;
                                    })
                                    ->CreateOptionModalHeading('Registrar Nuevo Cliente'),

                                Forms\Components\DatePicker::make('fecha')
                                    ->label('Fecha Realizada')
                                    ->readOnly()
                                    ->default(now('America/La_Paz')->format('Y-m-d')),

                                Forms\Components\DatePicker::make('fecha_limite')
                                    ->label('Fecha Limite')
                                    ->required()
                                    ->default(now('America/La_Paz')->addDays(14)->format('Y-m-d'))
                                    ->helperText('Fecha limite para la cotización'),



                                Forms\Components\Textarea::make('referencia')
                                    ->rows(3),

                                //creare un boton para crear producto
                                // Forms\Components\Grid::make('2')
                                //     ->schema([
                                //         Forms\Components\Actions\Action::make('resetStars')
                                //         ->icon('heroicon-m-x-mark')
                                //         ->color('danger')
                                //         ->requiresConfirmation()
                                //         ->action(fn() => dd('hola')),
                                //     ]),
                            ])
                    ])
            ]);
    }




    public function autoCompletarCliente(Forms\Get $get, Forms\Set $set): void
    {

        if (!$get('ci')) return;
        $cliente = Cliente::where('id', $get('ci'))->first();

        $set('nombre', $cliente->nombre);
        $set('nit', $cliente->nit);
        // $set('telefono', $cliente->telefono);
    }

    public function autoCompletarProducto(Forms\Get $get, Forms\Set $set): void
    {

        if (!$get('codigo_producto')) return;
        $producto = Producto::find($get('codigo_producto'));

        $cantidad = $get('cantidad');
        $subtotal = $producto->precio * $cantidad;
        //reddondear a 2 deciamles, poner cero si es entero
        // $subtotal = round($subtotal, 2);
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
        $productos = $get('../../detalles_venta');

        foreach ($productos as $producto) {
            $montoTotal += $producto['subtotal'];
        }
        // dd('llegmaos', $montoTotal);
        $montoTotal = number_format($montoTotal, 2, '.', '');
        $this->montoTotal = $montoTotal;
    }




    public function create($accion)
    {

        $data = $this->form->getState();
        // dd($data);
         try {
            $v = new Cotizacion();
            $v->fecha  =  $data['fecha'];
            $v->fecha_limite  =  $data['fecha_limite'];
            $v->total = $this->montoTotal;
            // $v->estado = 'pendiente';
            // $v->referencia = 'referencia';
            $v->cliente_id = $data['cliente_id'];
            $v->user_id = Auth::id();
            $v->save();

            foreach ($data['detalles_venta'] as $detalle) {

                $dv = new DetalleCotizacion();
                $dv->cotizacion_id = $v->id;
                $dv->producto_id = $detalle['codigo_producto'];
                $dv->cantidad = $detalle['cantidad'];
                $dv->precio = $detalle['precio'];
                $dv->save();
            }

                Notification::make()
                    ->title('Cotizacion Registrada con Exito!!')
                    ->success()
                    ->body("La Cotizacion Nro: {$v->id} se ha registrado correctamente")
                    ->send();

            if ($accion == 'create') {
                $this->reset();
                $this->form->fill();
                // $this->emit('scrollToTop');
                $this->dispatch('scrollToTop');
                return;
            }else{
                return redirect()->route('cotizacion.index');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }


    public function cancelar()
    {
        // Simplemente redirige a la lista de ventas sin hacer nada
        return redirect()->route('cotizacion.index');
    }
}
