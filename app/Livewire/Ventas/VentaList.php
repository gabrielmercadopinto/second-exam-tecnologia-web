<?php

namespace App\Livewire\Ventas;

use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\NotaVenta;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables;
use Filament\Forms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VentaList extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function render()
    {
        return view('livewire.ventas.venta-list');
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(NotaVenta::query())
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Nro Venta')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cliente.nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Vendedor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->searchable(), // Habilita la búsqueda en esta columna
                Tables\Columns\TextColumn::make('total'),
                Tables\Columns\TextColumn::make('metodo_pago.nombre'),
                Tables\Columns\TextColumn::make('transaccion.transaccion'),
            ])
            ->actions([

                //ir a algun url
                // Tables\Actions\Action::make('ir_detalles')
                //     ->label('Ir')
                //     ->url('venta.show', )
                //     ->openUrlInNewTab(false),

                Tables\Actions\ViewAction::make()
                    ->label('Ver Detalles')
                    ->modalHeading('Detalles de la Venta')
                    ->modalContent(function ($record){
                        $detalles = DetalleVenta::where('nota_venta_id',$record->id )->get();
                        $venta = $record;

                        return view('livewire.ventas.detalles-venta', compact(
                        'detalles' , 'venta'
                        ));
                    })

                    ->modal(),
                // Tables\Actions\EditAction::make()
                // ->modalHeading('Editar Producto')
                // ->label('Editar'),
                //aplicar roles y permiso, no mostrar para empleados
            //    ->visible(fn() => Auth::user()->can('producto.edit')),
               //boton eliminar
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\Action::make('ver_detalles')
                //     ->label('Ver Detalles')
                //     ->modalHeading('Detalles de la Venta')
                //     ->action(
                //         dd('hola xd xd')
                //         // fn ($record) => view('livewire.ventas.detalles-venta', ['detalles' => $record->detalles_venta] )
                //         )
                //     ->modal()

            ])
            ->headerActions([
                // Botón de redirección a la lista de marcas
               Tables\Actions\Action::make('ventas')
                   ->label('Realizar Venta')
                   ->url(route('venta.create'))
                   ->openUrlInNewTab(false),

            ]);
            // ->filters([
            //     // Filtrar por nombre
            //     Tables\Filters\InputFilter::make('cliente.nombre')
            //         ->label('Cliente')
            //         ->placeholder('Buscar por nombre'),
            //     // Filtrar por marca
            //     Tables\Filters\InputFilter::make('user.name')
            //         ->label('Vendedor')
            //         ->placeholder('Buscar por nombre'),
            //     // Filtrar por categoría
            //     Tables\Filters\DateRangeFilter::make('fecha')
            //         ->label('Fecha')
            //         ->placeholder('Buscar por fecha'),
            // ]);

    }
}
