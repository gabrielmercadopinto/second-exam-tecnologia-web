<div class="max-h-full rounded-lg my-2 ">


    <ol
        class="flex items-center w-full space-x-2 text-sm font-medium text-center text-gray-500
     sm:text-base sm:space-x-4 rtl:space-x-reverse border-b pb-3">
        <li class="flex items-center {{ $tab_select == 1 ? 'text-blue-600' : '' }} ">
            <button wire:click="setTab(1)" class="{{ $tab_select == 1 ? 'bg-gray-200 rounded-lg p-2' : '' }} "
                {{ $tab_select ? 'disabled' : '' }}>
                Registro de Venta
            </button>

            <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 12 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m7 9 4-4-4-4M1 9l4-4-4-4" />
            </svg>
        </li>
        <li class="flex items-center {{ $tab_select == 2 ? 'text-blue-600' : '' }}">

            <button wire:click="setTab(2)"
                class="{{ $tab_select == 2 ? 'bg-gray-200 rounded-lg px-2' : 'opacity-50 cursor-not-allowed' }} "
                {{ $tab_select ? 'disabled' : '' }}>
                Metodo de Pago
            </button>
            <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 12 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m7 9 4-4-4-4M1 9l4-4-4-4" />
            </svg>
        </li>
        <li class="flex items-center {{ $tab_select == 3 ? 'text-blue-600' : '' }}">

            <button wire:click="setTab(3)"
                class="{{ $tab_select == 3 ? 'bg-gray-200 rounded-lg px-2' : 'opacity-50 cursor-not-allowed' }} "
                {{ $tab_select ? 'disabled' : '' }}>
                Recibo
            </button>
        </li>
    </ol>

    <!-- Contenido dinámico según el paso -->
    <div class="mt-4 ">
        @if ($tab_select === 1)
            <div>
                {{ $this->form }}




                <p class="text-red-600 font-semibold"> {{ $mensaje_error }}</p>
            </div>
            <div class="flex justify-end space-x-3 font-medium">


                {{-- <button type="button" wire:click="create('index')"
            class="bg-gray-900 text-white rounded-lg py-1 px-2 mt-6">
                Realizar Venta
            </button>


            <button type="button"  wire:click="create('create')"
            class="bg-white  border text-gray-900 rounded-lg py-1 px-2 mt-6">
                Realizar Venta y Realizar otra Venta
            </button> --}}


                <button type="button"
                    wire:click="pasarMetodoPago"
                    wire:loading.attr="disabled"
                    wire:loading.class="bg-gray-200 text-gray-900 opacity-50 cursor-not-allowed"
                    wire:target="pasarMetodoPago"
                    class="bg-gray-900 text-white rounded-lg py-1 px-2 mt-6">
                    Pasar al Metodo de Pago
                </button>


                <button type="button" wire:click="cancelar()"
                    class="bg-white  border text-gray-900 rounded-lg py-1 px-2 mt-6">
                    Cancelar
                </button>
            </div>
        @elseif ($tab_select == 2)
            <div>
                {{-- The best athlete wants his opponent at his best. --}}
                {{-- <p> aqui podria ir un titulo o alguna informcaion extras xd xd </p> --}}
                <div class=" grid grid-cols-3 gap-6 ">
                    <div class="col-span-2 border rounded-xl ">
                        <div class="px-4 py-2 border-b  flex items-center ">
                            <span class="whitespace-nowrap">Seleccione el metodo de pago:</span>
                            <div class="font-medium w-full flex justify-around ">
                                <button wire:click="efectivo"
                                    class="{{ $estado_pago == 1 ? 'bg-gray-200 text-gray-900 opacity-50 cursor-not-allowed' : 'bg-black text-white' }}

                                    rounded  px-2 py-1  "
                                    {{ $estado_pago == 1 ? 'disabled' : '' }}>
                                    Efectivo
                                </button>


                                <button
                                    wire:click="generarQR"
                                    class="{{ $estado_pago == 2 ? 'bg-gray-200 text-gray-900 opacity-50 cursor-not-allowed' : 'bg-black text-white' }}
                                        rounded px-2 py-1 flex items-center whitespace-nowrap"
                                    {{ $estado_pago == 2 ? 'disabled' : '' }}>

                                    <span class="pr-2">Generar QR</span>

                                    <!-- Spinner de carga, visible solo durante el estado de carga -->
                                    <svg
                                        wire:loading
                                        wire:target="generarQR"
                                        aria-hidden="true"
                                        class="w-5 h-5 text-gray-200 animate-spin fill-blue-600"
                                        viewBox="0 0 100 101"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </button>

                            </div>
                        </div>
                        <div class="p-5"`
                            wire:loading.class=" opacity-50 cursor-not-allowed"
                            wire:target="generarQR"
                        >

                            @if ($this->QrImage && $estado_pago == 2)
                                <img src="{{ $this->QrImage }}" alt="qr" class="w-1/2 mx-auto">
                                <p class=" text-center font-mono font-medium">
                                    Pago con QR - Nro Transaccion: {{ $NroTransaccion }}
                                    <span class="text-red-500">
                                        {{ $mensaje_error }}
                                    </span>
                                </p>
                            @endif

                            @if ($estado_pago == 1)
                            <div class="flex flex-col items-center justify-center">
                                <!-- Imagen de carga -->
                                <img wire:loading wire:target="generarQR"
                                     src="{{ asset('images/loading.gif') }}"
                                     alt="loading"
                                     class="w-1/2 mx-auto" />

                                <!-- Imagen de pago efectivo, visible cuando no está en estado de carga -->
                                <img wire:loading.remove wire:target="generarQR"
                                     src="{{ asset('images/pago_efectivo.png') }}"
                                     alt="pago_efectivo"
                                     class="w-1/2 mx-auto" />

                                     {{-- cambair el valor del contenido --}}
                                <p class="text-center font-mono font-medium"
                                wire:loading.class="text-center font-mono font-medium"
                                wire:loading wire:target="generarQR"
                                >
                                    <span>
                                        Generando QR, espere por favor
                                    </span>
                                    <span class="text-red-500 ">
                                        {{ $mensaje_error }}
                                     </span>
                                </p>

                                <p class="text-center font-mono font-medium"
                                wire:loading.class="text-center font-mono font-medium"
                                wire:loading.remove wire:target="generarQR"
                                >
                                    Pago en Efectivo
                                    <span class="text-red-500">
                                      {{ $mensaje_error }}
                                     </span>
                            </p>

                            </div>



                            @endif


                        </div>
                    </div>
                    <div class="col-span-1 border   rounded-xl">
                        <p class="p-4 border-b  font-medium "> Resumen de Venta </p>
                        <div class="p-5 space-y-3 border-b">
                            <div class="border-b px-1 flex justify-between ">
                                <span class="font-medium pr-7"> Nombre</span>
                                <span class="font-medium"> Precio</span>
                                <span class="font-medium"> Cant.</span>
                                <span class="font-medium"> Subtotal</span>
                            </div>

                            @foreach ($this->dataProduct as $producto)
                                <div class="border-b px-1 flex justify-between ">
                                    <span> {{ $producto['nombre'] }}</span>
                                    <span> {{ $producto['precio'] }}</span>
                                    <span> {{ $producto['cantidad'] }}</span>
                                    <span> {{ $producto['subtotal'] }}</span>
                                </div>
                            @endforeach

                        </div>
                        <div class="p-4  space-y-2">

                            <div class="border-b px-1 flex justify-between ">
                                <span class="font-medium"> Total sin descuento xd </span>
                                <span> {{ $montoTotal }} Bs</span>
                            </div>
                            <div class="border-b px-1 flex justify-between ">
                                <span class="font-medium"> Descuento </span>
                                <span> {{ $descuentoTotal }} %</span>
                            </div>
                            <div class="border-b px-1 flex justify-between ">
                                <span class="font-medium"> Monto total</span>
                                <span> {{ $totalTotal }} Bs</span>
                            </div>


                        </div>
                    </div>
                    <div class="flex justify-end w-full col-span-3 space-x-5"
                            wire:loading.attr="disabled"
                            wire:loading.class=" opacity-50 cursor-not-allowed"
                            wire:target="generarQR"
                    >
                        @if ($estado_pago == 1 )
                            <button type="button" wire:click="create('index')"
                                class="bg-gray-900 text-white rounded-lg py-1 px-2">
                                Realizar Venta
                            </button>


                            <button type="button" wire:click="create('create')"
                                class="bg-white  border text-gray-900 rounded-lg py-1 px-2">
                                Realizar Venta y Realizar otra Venta
                            </button>
                        @endif

                        <button type="button" wire:click="cancelar()"
                            class="bg-white  border text-gray-900 rounded-lg py-1 px-2">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        @elseif ($tab_select == 3)

            <div class="p-5 space-y-4">
                <img src="{{ @asset('images/pago_exitoso.jpg') }}" alt="pago_exitoso">

               <div class="text-2xl font-mono text-center flex flex-col justify-center">

                <p> Transacion:  <span class="font-bold text-4xl">  {{ $NroTransaccion }}</span></p>
                <p> Pago realizado de:  <span class="font-bold text-4xl">  0.02 Bs</span></p>

                <button class=" flex justify-center items-center my-4 space-x-2 ">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
                      </svg>
                     <span>  Descargar factura</span>
                </button>

               </div>

               <div class="flex justify-end space-x-4">
                  <button class="bg-gray-900 text-gray-50 rounded-lg px-2 py-1">
                    Realizar otra venta
                  </button>
                  <button class="border-2 border-gray-900  rounded-lg px-2 py-1">
                    Ir a la lista de ventas
                  </button>
               </div>

            </div>


        @endif
    </div>





    <x-filament-actions::modals />


    @script
        <script>
            $wire.on('scrollToTop', () => {
                console.log('evento escuchaod scrollToTop');

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // Desplazamiento suave hacia arriba
                });
            });


            $wire.on('consultar_estado', async () => {
                let component = @this;
                let estado = 1;
                let bandera = true;

                while (estado == 1 && bandera) {
                    let result = await component
                .consultarEstado(); // Asegúrate de usar 'await' si es una función async
                    if (result.error == 1) {
                        bandera = false;
                        component.mensaje_error == result.mensaje;
                        break;
                    }

                    console.log(result);
                    estado = result.values[0].Estado;

                    if (estado == 2) {
                        component.mensaje_error = '';
                        bandera = false;
                        // 'ejecutar  un metodo'
                        component.pagoConfirmado();
                        break;
                    }

                    // Esperar 5 segundos
                    await new Promise(resolve => setTimeout(resolve, 5000)); // Corrige aquí: 'ms' debe ser 5000
                }

                if (estado == 4) {
                    component.mensaje_error = 'El pago fue anulado';
                }
            });
        </script>
    @endscript
</div>
