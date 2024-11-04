<?php

namespace App\Livewire;

use App\Models\Categoria;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;


use Livewire\Component;

class ListCategoria extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function render()
    {
        return view('livewire.list-categoria');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Categoria::query()) // Query de la tabla
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('descripcion')->searchable()->toggleable()->limit(20),
                Tables\Columns\IconColumn::make('estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading('Crear Categoria') // Título del modal
                    ->modal()
                    ->label('Crear Categoria') // Etiqueta del botón
                    ->form([
                        Forms\Components\TextInput::make('nombre')
                            ->required(),
                        Forms\Components\Textarea::make('descripcion')
                            ->rows(6),
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
                            ->required(),
                            Forms\Components\Textarea::make('descripcion')
                            ->rows(6)
                            ->placeholder('Descripcion')
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
