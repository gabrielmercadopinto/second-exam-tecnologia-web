<?php

namespace App\Livewire\Ventas;

use App\Livewire\ListVenta;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\MetodoPago;
use App\Models\NotaVenta;
use App\Models\Producto;
use App\Models\Transaccion;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VentaCreate extends Component implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    public ?array $products = [];
    public ?array $client = [];
    public ?array $detalles_venta = [];
    public $cargando_qr = false;
    public $vista_actual = 1;
    public $QrImage;
    public $dataCliente = [];
    public $dataProduct = [];

    //variables para el tab
    public $tab_select = 1;
    public $estado_pago = 1;
    public $NroTransaccion;
    public $token;
    public $mensaje_error = '';

    //datos cliente
    public $montoTotal = 0;
    public $descuentoTotal = 0;
    public $totalTotal = 0;




    public function render()
    {
        // Auth::id();
        return view('livewire.ventas.venta-create');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function setTab($tab)
    {
        $this->tab_select = $tab;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(4)
                    ->schema([
                        Forms\Components\Section::make('Detalles de Venta')
                            ->columnSpan(3)
                            ->columns(4)
                            ->schema([
                                Forms\Components\Repeater::make('detalles_venta')
                                    ->label(false)
                                    ->addActionLabel('Agregar Producto')
                                    ->minItems(1)
                                    ->columnSpan(4)
                                    ->reorderableWithButtons()
                                    ->afterStateUpdated(
                                        function ($state) {
                                            $montoTotal = 0;
                                            foreach ($state as $s) {
                                                $montoTotal += $s['subtotal'];
                                            }
                                            // dd('llegmaos', $montoTotal);
                                            $montoTotal = number_format($montoTotal, 2, '.', '');
                                            $this->montoTotal = $montoTotal;
                                        }
                                    )
                                    ->schema([

                                        Forms\Components\Grid::make(6) // Definir el grid con 3 columnas
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
                                                    ->extraInputAttributes(['style' =>  'text-align: right;'])
                                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => $this->calculateSubTotal($get, $set)),

                                                Forms\Components\TextInput::make('cantidad_disponible')
                                                ->label('Cant. Disponible')
                                                ->numeric()
                                                ->readOnly()
                                                ->default(0)
                                                ->reactive()
                                                ->extraInputAttributes(['style' =>  'text-align: right;']),

                                                Forms\Components\TextInput::make('cantidad')
                                                    ->label('Cantidad')
                                                    ->required()
                                                    ->numeric()
                                                    ->default(1)
                                                    ->integer()
                                                    ->reactive()
                                                    ->extraInputAttributes(['style' =>  ' text-align: right;'])
                                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => $this->calculateSubTotal($get, $set)),
                                                Forms\Components\TextInput::make('subtotal')
                                                    ->label('Sub Total')
                                                    ->required()
                                                    ->numeric()
                                                    ->default(0)
                                                    ->reactive()
                                                    ->extraInputAttributes(['style' =>  ' text-align: right;'])
                                                    ->readOnly(),
                                            ])
                                    ]),
                            ]),

                        Forms\Components\Section::make('Detalle de Venta')
                            ->columnSpan(1)
                            ->compact()
                            ->schema([
                                Forms\Components\Select::make('ci')
                                    ->label('Carnet de identidad')
                                    ->options(
                                        Cliente::all()->mapWithKeys(function ($cliente) {
                                            return [$cliente->id => $cliente->ci . ' - ' . $cliente->nombre];
                                        })
                                    )
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->placeholder('Buscar...')
                                    ->createOptionForm([
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
                                // Forms\Components\TextInput::make('nit')
                                //     ->label('NIT'),
                                // Forms\Components\TextInput::make('nombre'),



                                Forms\Components\Placeholder::make('monto_total_text')
                                    ->label(false)
                                    // ->content('Monto Total: $:')
                                    ->content(fn() => "Total sin descuento: " . $this->montoTotal . " Bs")
                                    ->columnSpan('full')
                                    ->extraAttributes([
                                        'style' => '
                                                text-align:right;
                                                font-weight: 500;
                                                font-size: 1rem;
                                                border-bottom: 1px solid #e5e7eb;
                                                '
                                    ]),

                                    Forms\Components\TextInput::make('descuento')
                                        ->label(false)
                                        ->prefix('Descuento')
                                        ->suffix('%')
                                        ->numeric()
                                        ->default(0)
                                        ->integer()
                                        ->reactive()
                                        ->extraInputAttributes(['style' =>  ' text-align: right;'])
                                        ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => $this->aplicarDescuento($get, $set)),


                                        Forms\Components\Placeholder::make('total_total')
                                        ->label(false)
                                        ->content(fn() => "Monto total: " . $this->totalTotal . " Bs")
                                        ->columnSpan('full')
                                        ->extraAttributes([
                                            'style' => '
                                                    text-align:right;
                                                    font-weight: 500;
                                                    font-size: 1rem;
                                                    border-bottom: 1px solid #e5e7eb;
                                                    '
                                        ]),


                            ]),

                    ])
            ])
            ->statePath('data')
            ->model(NotaVenta::class);
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
        $set('cantidad_disponible', $producto->stock);
        // $set('cantidad', $producto->cantidad);
        $set('subtotal', $subtotal);


        $this->calculoMontoTotal($get, $set);
    }


    public function aplicarDescuento(Forms\Get $get, Forms\Set $set): void
    {
        if (!$get('descuento')) return;

        $descuento = $get('descuento');
        $this->descuentoTotal = $descuento;
        //aplciar descuento a monto total y mostrarlo en totalTotal
        $total = $this->montoTotal - ($this->montoTotal * $descuento / 100);
        $total = number_format($total, 2, '.', '');
        $this->totalTotal = $total;

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
        try {
        $this->mensaje_error = '';

        $montoTotal = 0;
        $productos = $get('../../detalles_venta');
        // dd('llegmaos', $productos);
        foreach ($productos as $producto) {
            $montoTotal += $producto['subtotal'];
            // $producto = Producto::where('id', $detalle['codigo_producto'])->first();
            $validarProducto = Producto::where('id', $producto['codigo_producto'])->first();
            $validarCantidad = $producto['cantidad'];

            //verificar si hay stock disponnible
            if ($validarProducto->stock < $validarCantidad) {


                Notification::make()
                    ->title('Error, Stock Insuficiente')
                    ->danger()
                    ->color('danger')
                    ->persistent()
                    ->body("Solo hay {$validarProducto->stock} unidades de {$validarProducto->nombre} en stock")
                    ->send();

                return;
            }
        }


        $montoTotal = number_format($montoTotal, 2, '.', '');
        $this->montoTotal = $montoTotal;
        // $set('../../total_sin_descuento', $montoTotal);
        //aplicar descuento

        $descuento = $get('../../descuento');
        //aplciar descuento a monto total y mostrarlo en totalTotal
        $total = $this->montoTotal - ($this->montoTotal * $descuento / 100);
        $total = number_format($total, 2, '.', '');
        $this->totalTotal = $total;
        } catch (\Throwable $th) {
            dd($th);
        }


    }


    // Forms\Components\Tabs\Tab::make('Metodo de Pago')
    //                         ->icon('heroicon-o-credit-card')
    //                         // ->extraAttributes(function () {

    //                         //     return $this->cargando_qr ? [] : [
    //                         //         'style' => '
    //                         //         background-color: #f8f9fa;
    //                         //         pointer-events: none;
    //                         //         opacity: 0.5;
    //                         //     '
    //                         //     ];
    //                         // })
    //                         ->schema([
    //                             Forms\Components\View::make('livewire.ventas\venta-metodo-pago'), // Renderiza el componente Livewire

    //                         ]),



    public function pasarMetodoPago()
    {
        //validar datos
        $data = $this->form->getState();
        $this->QrImage = null;
        $this->dataProduct = [];
        foreach ($data['detalles_venta'] as $detalle) {
            $producto = Producto::where('id', $detalle['codigo_producto'])->first();
            $this->dataProduct[] = [
                'codigo_producto' => $producto->codigo_oem,
                'nombre' => $producto->nombre,
                'cantidad' => $detalle['cantidad'],
                'precio' => $detalle['precio'],
                'subtotal' => $detalle['subtotal'],
            ];

            // $validarCantidad = $detalle['cantidad'];

            //verificar si hay stock disponnible
            if ($producto->stock < $detalle['cantidad']) {

                $this->mensaje_error = "*Solo hay {$producto->stock} unidades de {$producto->nombre} en stock";
                return;
            }


        }
        // dd($this->dataProduct);

        // $this->dataCliente = [
        //     'ci' =>  $data['ci'],
        //     'monto_total' => $data['total_sin_descuento'],
        //     // 'descuento' => $data['descuento'],
        //     // 'totalTotal' => $data['total_total'],
        // ];

        $this->tab_select = 2;
    }


    public function create($accion)
    {

        $data = $this->form->getState();
        // dd($data);
        try {
            $v = new NotaVenta();
            //solo poner fecha
            // $v->fecha  = now('America/La_Paz')->format('Y-m-d');
            // $v->hota = now('America/La_Paz')->format('H:i:s');
            // $v->total = $data['total_sin_descuento'];
            $v->total = $this->totalTotal;
            $v->descuento = $this->descuentoTotal;
            $v->estado = 'pendiente';
            $v->cliente_id = $data['ci']; //en realidad es si id de cliente
            $v->user_id = Auth::id();
            $v->metodo_pago_id = $this->estado_pago;
            if ($this->NroTransaccion && $this->estado_pago == 2) {
                $v->transaccion_id = Transaccion::where('transaccion', $this->NroTransaccion)->first()->id;
            }
            $v->save();

            foreach ($data['detalles_venta'] as $detalle) {
                $producto = Producto::where('id', $detalle['codigo_producto'])->first();

                $dv = new DetalleVenta();
                $dv->nota_venta_id = $v->id;
                $dv->producto_id = $detalle['codigo_producto'];
                $dv->cantidad = $detalle['cantidad'];
                $dv->precio = $detalle['precio'];
                $dv->save();

                $producto->stock -= $detalle['cantidad'];
                $producto->save();
            }

            Notification::make()
                ->title('Venta Registrada Correctamente')
                ->success()
                ->body("La venta Nro: {$v->id} se ha registrado correctamente")
                ->send();

            if ($accion == 'create') {
                $this->reset();
                $this->form->fill();
                // $this->emit('scrollToTop');
                $this->dispatch('scrollToTop');
                return;
            } else {
                if ($accion == 'index') {
                    return redirect()->route('venta.index');
                }
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }


    public function cancelar()
    {
        // Simplemente redirige a la lista de ventas sin hacer nada
        return redirect()->route('venta.index');
    }



    public function efectivo()
    {
        $this->estado_pago = 1;
    }


    public function pagoConfirmado()
    {
        $this->create('qr');
        $this->tab_select = 3;
    }

    public function generarQR()
    {
        $this->cargando_qr = true;
        $this->estado_pago = 2;

        if ($this->QrImage != null) {
            $this->cargando_qr = false;
            return;
        }


        $laPedidoDetalle = [];
        $lnLength = 1;
        $lnMontoTotal = 0;
        for ($i = 0; $i < $lnLength; $i++) {
            $laPedidoDetalle[] = [
                "Serial" => $i + 1,
                "Producto" => 'cod001',
                "Cantidad" => '2',
                "Precio" => '0.01',
                "Descuento" => "0",
                "Total" => '0.02'
            ];
            $lnMontoTotal += '0.02';
        }


        try {
            $lcComerceID           = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $lnMoneda              = 2;
            $lnTelefono            = '78021105';
            $lcNombreUsuario       = 'cris';
            $lnCiNit               = '0';
            $lcNroPago             = "CrisTest-" . rand(100000, 999999);  //se lo puede poner una venta
            $lnMontoClienteEmpresa = $lnMontoTotal;
            $lcCorreo              = "ccuellar260@gmail.com";
            $lcUrlCallBack         = "";
            $lcUrlReturn           = "";
            // $laPedidoDetalle       = $request->taPedidoDetalle; //poner detalle
            $lcUrl                 = "";


            $loClient = new Client();
            $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody   = [
                "tcCommerceID"          => $lcComerceID,
                "tnMoneda"              => $lnMoneda,
                "tnTelefono"            => $lnTelefono,
                'tcNombreUsuario'       => $lcNombreUsuario,
                'tnCiNit'               => $lnCiNit,
                'tcNroPago'             => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo"              => $lcCorreo,
                'tcUrlCallBack'         => $lcUrlCallBack,
                "tcUrlReturn"           => $lcUrlReturn,
                'taPedidoDetalle'       => $laPedidoDetalle
            ];


            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);


            $laResult = json_decode($loResponse->getBody()->getContents());
            $this->NroTransaccion = explode(';', $laResult->values)[0];

            $laValues = explode(";", $laResult->values)[1];
            // dd($laValues);

            //crear transaccion
            //fecha y hora de bolivia
            Transaccion::create([
                'transaccion' => $this->NroTransaccion,
                'fecha_validez' => json_decode($laValues)->expirationDate,
                'estado' => 1,
            ]);

            // dd($laResult);
            $this->dispatch('consultar_estado');

            $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;

            $this->QrImage = $laQrImage;
            $this->cargando_qr = false;
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    public function obtener_token()
    {

        try {
            //code...
            $pcTokenService = "a52063a1be51238364d1e55c3132f7c3b0625cfab2f37ac522a85cabaebdeb9978dbe5966e0b970ba696ec4caf9aa5661802935f86717c481f1670e63f35d5042f245c19d1846aade72f31ce0626ca3aa85b747005fc7ce00270c2a27d530257122c6439424585beb693e9e3bcceffb7407630d7b0482a983a469d88ce374f68123";
            $pcTokenSecret = "3B1C4B249F144B488D922280123";

            $loClient = new Client();
            $lcUrl = 'https://serviciosbroker.pagofacil.com.bo/api/login';
            $laHeader = [
                'Accept' => 'application/json'
            ];


            $laBody = [
                "TokenService" => $pcTokenService,
                "TokenSecret" => $pcTokenSecret
            ];

            $Response = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);



            $laResult = json_decode($Response->getBody()->getContents());


            return $laResult;
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }


    public function consultarEstado()
    {

        try {
            if (is_null($this->token)) {
                $token = $this->obtener_token();
                if ($token->error == 1) {
                    dd($token->message);
                }

                $this->token = $token->values;
            }


            $loClient = new Client();
            $lcUrl = 'https://serviciosbroker.pagofacil.com.bo/api/consultarestado';
            $laHeader = [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token,
            ];
            //body con tnTransaccion
            $laBody = [
                "tnTransaccion" => $this->NroTransaccion
            ];
            $Response = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);

            // dd($Response->getBody()->getContents());

            $laResult = json_decode($Response->getBody()->getContents());





            return $laResult;
        } catch (\Throwable $th) {
            //throw $th;

            dd($th);
        }




        // return 'constulando xd xd ';



    }



}
