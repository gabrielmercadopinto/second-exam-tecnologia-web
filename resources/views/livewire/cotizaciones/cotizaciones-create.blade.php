<div>
   {{ $this->form }}

<div class="flex justify-end space-x-3 font-medium    mt-4">

    <button type="button" wire:click="create('index')"
    class="bg-gray-900 text-white rounded-lg py-1 px-2">
        Realizar Compra
    </button>


    <button type="button"  wire:click="create('create')"
     class="bg-white  border text-gray-900 rounded-lg py-1 px-2 ">
        Realizar Compra y Realizar otra Compra
    </button>

    <button type="button" wire:click="cancelar()"
    class="bg-white  border text-gray-900 rounded-lg py-1 px-2 ">
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
