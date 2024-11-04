<?php

namespace App\Livewire\Compras;

use App\Models\DetalleCompra;
use App\Models\NotaCompra;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables;
use Filament\Forms;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class CompraList extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function render()
    {
        return view('livewire.compras.compra-list');
    }

    public function  table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(NotaCompra::query())
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Nro Compra')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('proveedor.nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Vendedor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->searchable(), // Habilita la búsqueda en esta columna
                Tables\Columns\TextColumn::make('total'),
            ])->headerActions([
                Tables\Actions\Action::make('proveedores')
                    ->label('Lista de Proveedores') // Asegúrate de definir un label para que se muestre el texto
                    ->url(route('proveedor.index')) // Redirige a la ruta VMarca.index
                    ->openUrlInNewTab(false), // Define si la URL se abre en la misma pestaña o una nueva

                // Botón de redirección a la lista de marcas
               Tables\Actions\Action::make('compras')
                   ->label('Realizar Compra')
                   ->url(route('compra.create'))
                   ->openUrlInNewTab(false),
            ])
            ->actions([
                //ver detalles
                Tables\Actions\ViewAction::make()
                    ->label('Ver Detalles')
                    ->modalHeading('Detalles de la Compra')
                    ->modalContent(function ($record){
                        $detalles = DetalleCompra::where('nota_compra_id',$record->id )->get();
                        $compra = $record;

                        return view('livewire.compras.detalles-compra', compact(
                        'detalles' , 'compra'
                        ));
                    })
                    ->modal(),
                //editar
                Tables\Actions\Action::make('editar'),
                    // ->label('Editar')
                    // ->icon('heroicon-o-pencil')
                    // ->color('primary')
                    // // ->url(fn ($record) => route('compra.edit', $record->id))
                    // ->openUrlInNewTab(false), // Cambia a true si quieres abrir en una nueva pestaña


                //elimnar
                Tables\Actions\DeleteAction::make(),
            ]);

    }





}
