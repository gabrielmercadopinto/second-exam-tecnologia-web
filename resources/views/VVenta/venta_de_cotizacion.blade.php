<x-app-layout>
    <x-slot name="header">
         Realizar Venta
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-3 text-gray-900">
                    @livewire('ventas.venta-de-cotizacion')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
