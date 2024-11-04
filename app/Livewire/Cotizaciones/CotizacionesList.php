<?php

namespace App\Livewire\Cotizaciones;

use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Models\DetalleVenta;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables;
use Filament\Forms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CotizacionesList extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;
    public function render()
    {
        return view('livewire.cotizaciones.cotizaciones-list');
    }

    public function  table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(Cotizacion::query())
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Nro Cotizacion')
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
                Tables\Columns\TextColumn::make('fecha_limite'),
                Tables\Columns\TextColumn::make('total'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->label('Ver Detalles')
                ->modalHeading('Detalles de la Cotizacion')
                ->modalContent(function ($record){
                    $detalles = DetalleCotizacion::where('cotizacion_id',$record->id )->get();
                    $cotizacion = $record;

                    return view('livewire.cotizaciones.detalles-cotizacion', compact(
                    'detalles' , 'cotizacion'
                    ));
                })
                ->modal(),


                Tables\Actions\Action::make('pasar_venta')
                    ->label('Pasar a venta')
                    ->icon('heroicon-o-arrow-right')
                    ->color('success')
                    ->url(fn ($record) => route('venta.create'))
                    ->openUrlInNewTab(false), // Cambia a true si quieres abrir en una nueva pestaña


                // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('editar')
                    ->label('Editar')
                    ->icon('heroicon-o-pencil')
                    ->url(fn ($record) => route('cotizacion.edit', ['cotizacion' => $record->id]))
                    ->openUrlInNewTab(false), // Cambia a true si deseas que se abra en una nueva pestaña
                Tables\Actions\DeleteAction::make(),


            ])

            ->headerActions([
                // Botón de redirección a la lista de marcas

               Tables\Actions\Action::make('cotizacion_create')
                   ->label('Realizar Cotizacion')
                   ->url(route('cotizacion.create'))
                   ->openUrlInNewTab(false),
            ]);
    }

}
