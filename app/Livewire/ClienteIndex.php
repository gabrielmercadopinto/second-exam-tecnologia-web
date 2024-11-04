<?php

namespace App\Livewire;

use App\Models\Cliente;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables;
use Filament\Forms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ClienteIndex extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function render()
    {
        return view('livewire.cliente-index');
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(Cliente::query())
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(), // Habilita la búsqueda en esta columna
                Tables\Columns\TextColumn::make('ci')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nit'),
            ])
            ->actions([
                // Acción para Editar
                Tables\Actions\EditAction::make()
                    ->modalHeading('Editar Cliente')
                    ->label('Editar')
                    ->modal()
                    ->model(Cliente::class)
                    ->form([
                        Forms\Components\TextInput::make('ci')
                            ->label('Carnet de Identidad')
                            ->numeric()
                            ->requiredWithout('nit'),
                        Forms\Components\TextInput::make('nit')
                            ->label('NIT')
                            ->numeric()
                            ->requiredWithout('ci'),

                        Forms\Components\TextInput::make('nombre')
                            ->required(),
                    ]),




                    // Acción para Eliminar
                Tables\Actions\DeleteAction::make()

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Crear Cliente')  // Asegúrate de definir un label para que se muestre el texto
                ->modalHeading('Nuevo Cliente')
                ->modal()
                // ->visible(fn() => Auth::user()->can('producto.create'))
                ->model(Cliente::class)
                ->form([
                    Forms\Components\TextInput::make('ci')
                        ->label('Carnet de Identidad')
                        ->numeric()
                        ->requiredWithout('nit'),
                    Forms\Components\TextInput::make('nit')
                        ->label('NIT')
                        ->numeric()
                        ->requiredWithout('ci'),

                    Forms\Components\TextInput::make('nombre')
                        ->required(),
                ])
            ]);

    }
}
