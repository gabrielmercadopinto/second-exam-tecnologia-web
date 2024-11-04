<div class="p-5">

    <style>
        .filament-modal-close-button {
            display: none !important;
        }
    </style>

    {{-- {{ $detalles }} --}}
    <div class="flex justify-between pr-8 font-semibold">
        <div class="flex flex-col   space-y-2">
            <div>
                <p class="">
                    Cliente:
                </p>
                <p class="font-normal pl-2">
                    {{ $venta->cliente->nombre }} - {{ $venta->cliente->nit }}
                </p>
            </div>
            <div>
                <p class="">
                    Telefono:
                </p>
                <p class="font-normal pl-2">
                    {{ $venta->cliente->telefono }}
                </p>
            </div>
            {{-- <div>
                <p class="">
                    Telefono:
                </p>
                <p class="font-normal">
                    {{ $cliente->telefono }}
                </p>
            </div> --}}
        </div>


        <div class="flex flex-col space-y-2">
            <div>
                <p>
                    Vendido por:
                </p>
                <p class="font-normal pl-2">
                    {{ $venta->user->name }}
                </p>
            </div>
            <div>
                <p>
                    Rol Vendidor:
                </p>
                <p class="font-normal pl-2">
                    {{ $venta->user->roles->first()->name }}
                </p>
            </div>
        </div>


        <div class="flex flex-col space-y-2">
            <div>
                <p>
                    Metodo de Pago:
                </p>
                <p class="font-normal pl-2">
                    {{ $venta->metodo_pago->nombre }}
                </p>
            </div>

            <div>
                <p class="">
                    Nro Transaccion:
                </p>
                <p class="font-normal pl-2">
                    {{ $venta->transaccion_id }}
                </p>
            </div>
        </div>
    </div>



<div class="relative overflow-auto h-64 mt-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Producto
                </th>
                <th scope="col" class="px-6 py-3">
                    Cantidad
                </th>
                <th scope="col" class="px-6 py-3">
                    Precio
                </th>
                <th scope="col" class="px-6 py-3">
                    Subtotal
                </th>
            </tr>
        </thead>
        <tbody>

           @foreach ($detalles as $detalle )

            <tr class="bg-white dark:bg-gray-800">
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $detalle->producto->nombre }}
                </th>
                <td class="px-6 py-4">
                    {{ $detalle->cantidad }}
                </td>
                <td class="px-6 py-4">
                    {{ $detalle->precio }}
                </td>
                <td class="px-6 py-4">
                    {{ $detalle->cantidad * $detalle->precio }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<div class=" flex   justify-between ">

    <div>
        <button class="bg-gray-950 text-gray-50 rounded-lg py-2 px-1 cursor-not-allowed opacity-40">
            Descargar Factura
        </button>
    </div>

    <div class="flex flex-col font-medium text-xl">
        <p class="flex justify-between space-x-4">
            <span>Total sin descuento:</span>
            <span>{{ number_format($venta->total / (1 - $venta->descuento / 100), 2) }} Bs</span>
        </p>
        <p class="flex justify-between"> Descuento: <span> {{ $venta->descuento }} %</span></p>
        <p  class="flex justify-between">  Monto total: <span>{{ $venta->total }} Bs</span></p>
    </div>
</div>



</div>
