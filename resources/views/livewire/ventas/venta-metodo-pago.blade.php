<div>
    {{-- The best athlete wants his opponent at his best. --}}
    {{-- <p> aqui podria ir un titulo o alguna informcaion extras xd xd </p> --}}
    <div class=" grid grid-cols-3 gap-8">
        <div class="col-span-2 border rounded-xl ">
            <p class="p-4 border-b font-medium ">Generando QR....
                <button wire:click="generarQR" class="bg-black text-white ">
                    generar qr
                </button>
            </p>
            <div class="p-5 ">


                @if ($this->QrImage)
                    <img src="{{ $this->QrImage }}" alt="qr" class="w-1/2 mx-auto">
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
                        <span > {{ $producto[''] }}</span>
                        <span > Monto Sin Descuento</span>
                        <span> 46.00 Bs</span>
                        <span> 46.00 Bs</span>
                    </div>

                @endforeach
                {{-- <div class="border-b px-1 flex justify-between ">
                    <span class="font-medium"> Monto Sin Descuento</span>
                    <span> 46.00 Bs</span>
               </div>

               <div class="border-b px-1 flex justify-between ">
                <span class="font-medium"> Descuento </span>
                <span> 46.00 Bs</span>
                 </div> --}}
                {{-- <div class="border-b px-1 flex justify-between ">
                    <span > Broca XL XL</span>

                    <span> 46.00 Bs</span>
                    <span> 5</span>
                    <span> 543.00 Bs</span>
                </div> --}}


                {{-- <div class="border-b px-1 flex justify-between ">
                    <span class="font-medium"> Metodo de pago</span>
                    <span> 46.00 Bs</span>
                </div> --}}

            </div>
            <div class="p-4  space-y-2">
                <div class="border-b px-1 flex justify-between ">
                    <span class="font-medium"> Total sin descuento</span>
                    <span> 46.00 Bs</span>
                </div>
                <div class="border-b px-1 flex justify-between ">
                    <span class="font-medium"> Descuento </span>
                    <span> 0,0 Bs</span>
                </div>
                <div class="border-b px-1 flex justify-between ">
                    <span class="font-medium"> Monto total</span>
                    <span> 46.00 Bs</span>
                </div>

            </div>


        </div>
    </div>
</div>
