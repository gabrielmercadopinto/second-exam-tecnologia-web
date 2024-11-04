<?php

namespace App\Livewire;


use App\Models\Marca;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;

use Livewire\Component;

class ListMarca extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function render()
    {
        return view('livewire.list-marca');
    }

    public function table(): Table
    {
        return Table::make($this)
            ->query(Marca::query()) // Query de la tabla
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('estado')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->trueColor('success')
                ->falseColor('danger')
                ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading('Crear Marca') // Título del modal
                    ->modal()
                    ->label('Crear Marca') // Etiqueta del botón
                    ->form([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre')
                            ->placeholder('Nombre de la marca')
                            ->required(),
                            Forms\Components\Radio::make('estado')
                            ->inline()
                            ->default(1)
                            ->options([
                                1 => 'Habilitado',
                                0 => 'Deshabilitado',
                            ])
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre')
                            ->required(),
                        Forms\Components\Radio::make('estado')
                            ->inline()
                            ->options([
                                1 => 'Habilitado',
                                0 => 'Deshabilitado',
                            ]),
                    ]),
                Tables\Actions\DeleteAction::make()
            ]);
    }
}
