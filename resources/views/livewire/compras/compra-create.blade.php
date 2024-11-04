<div>
    <div>
        {{ $this->form }}
    </div>
    <div class="text-right  mt-4">
        <label for="monto_total" class="font-semibold text-sm "> Monto Total:</label>
        <input wire:model="montoTotal" type="number" name="monto_total" id="monto_total" disabled
            class="border-b-2 border-0 border-b-gray-300  mx-2 text-right p-0">
    </div>
    {{-- <div class="text-right  mt-4">
        <label for="monto_total" class="font-semibold text-sm "> Descuento:</label>
        <input  type="number" name="monto_total" id="monto_total"
            class="border-2 rounded-lg  border-gray-300  mx-2 text-right w-44">
    </div>
    <div class="text-right  mt-4">
        <label for="monto_total" class="font-semibold text-sm "> Monto Total:</label>
        <input  type="number" name="monto_total" id="monto_total" disabled
            class="border-b-2 border-0 border-b-gray-300  mx-2 text-right p-0 ">
    </div> --}}
    <div class="flex justify-end space-x-3 font-medium mt-8">

        <button type="button" wire:click="create('index')"
        class="bg-gray-900 text-white rounded-lg py-1 px-2 mt-6">
            Realizar Compra
        </button>


        <button type="button"  wire:click="create('create')"
         class="bg-white  border text-gray-900 rounded-lg py-1 px-2 mt-6">
            Realizar Compra y Realizar otra Compra
        </button>

        <button type="button" wire:click="cancelar()"
        class="bg-white  border text-gray-900 rounded-lg py-1 px-2 mt-6">
            Cancelar
        </button>
    </div>

    <x-filament-actions::modals />

    @script
    <script>
        $wire.on('scrollToTop', () => {
            console.log('evento escuchaod scrollToTop');

            window.scrollTo({
                top: 0,
                behavior: 'smooth'  // Desplazamiento suave hacia arriba
            });
        });
    </script>
    @endscript
</div>
