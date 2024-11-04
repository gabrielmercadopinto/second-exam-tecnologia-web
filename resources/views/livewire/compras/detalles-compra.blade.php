<div class="p-5">
    {{-- {{ $detalles }} --}}
    <div class="flex justify-around pr-8 font-semibold">
        <div class="flex flex-col   space-y-2">
            <div>
                <p class="">
                    Cliente:
                </p>
                <p class="font-normal pl-2">
                    {{-- {{ $compra->proveedor->nombre }} - {{ $compra->proveedor->nit }} --}}
                </p>
            </div>
            <div>
                <p class="">
                    Telefono:
                </p>
                <p class="font-normal pl-2">
                    {{-- {{ $compra->proveedor->telefono }} --}}
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
                    Comprado por:
                </p>
                <p class="font-normal pl-2">
                    {{ $compra->user->name }}
                </p>
            </div>
            <div>
                <p>
                    Rol Comprador:
                </p>
                <p class="font-normal pl-2">
                    {{ $compra->user->roles->first()->name }}
                </p>
            </div>
        </div>


        {{-- <div class="flex flex-col space-y-2">
            <div>
                <p>
                    Metodo de Pago:
                </p>
                <p class="font-normal pl-2">
                    {{ $compra->metodo_pago->nombre }}
                </p>
            </div>

            <div>
                <p class="">
                    Nro Transaccion:
                </p>
                <p class="font-normal pl-2">
                    {{ $compra->transaccion_id }}
                </p>
            </div>
        </div> --}}
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
                    {{-- {{ $detalle->producto->nombre }} --}}
                    prod1
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


<div class=" flex   justify-end ">



    <div class="flex flex-col font-medium text-xl">
         <p  class="flex justify-between space-x-3">
            <span>Monto total: </span>
            <span>{{ $compra->total }} Bs</span></p>
    </div>
</div>



</div>
