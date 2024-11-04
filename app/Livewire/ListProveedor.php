<?php

namespace App\Livewire;

use App\Models\Proveedor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;
use Livewire\Component;

class ListProveedor extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;
    public function render()
    {
        return view('livewire.list-proveedor');
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(Proveedor::query())
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('nit')
                    ->searchable(),

                    Tables\Columns\TextColumn::make('ci')
                    ->searchable(),

                    Tables\Columns\TextColumn::make('telefono')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('correo')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('direccion')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('empresa')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('estado')
                    ->searchable(),


            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable',
                    ])
                    ])


            ->headerActions([

                Tables\Actions\CreateAction::make()
                    ->label('Registrar Proveedor')  // Asegúrate de definir un label para que se muestre el texto
                    ->modalHeading('Registrar Proveedor')
                    ->slideOver()
                    // ->visible(fn() => Auth::user()->can('producto.create'))
                    ->model(Proveedor::class)
                    ->form([
                        //grid de 3 columans
                        Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('nombre')
                                ->required()
                                ->columnSpan(2),
                                //ejeuctar metodo, conveira a mayuscula


                                // Ocupa 2 columnas
                            Forms\Components\TextInput::make('correo')
                                ->label('Correo')
                                ->email(),

                                Forms\Components\TextInput::make('telefono')
                                ->integer(),

                                Forms\Components\TextInput::make('direccion'),

                                Forms\Components\TextInput::make('ci'),
                                Forms\Components\TextInput::make('nit'),
                                Forms\Components\TextInput::make('empresa'),
                                Forms\Components\Radio::make('estado')
                                ->default(1)
                                ->options([
                                    1 => 'Habilitado',
                                    0 => 'Deshabilitado',
                                ])


                         ]),
                        ])

            ])
            ->actions([
                 // Acción para Editar
                 Tables\Actions\EditAction::make()
                 ->modalHeading('Editar Proveedor')
                 ->label('Editar')
                 //aplicar roles y permiso, no mostrar para empleados
                // ->visible(fn() => Auth::user()->can('producto.edit'))
                 ->form([
                    Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                        ->required()
                        ->columnSpan(2),
                        //ejeuctar metodo, conveira a mayuscula


                        // Ocupa 2 columnas
                    Forms\Components\TextInput::make('correo')
                        ->label('Correo')
                        ->required()
                        ->email(),

                        Forms\Components\TextInput::make('telefono')
                        ->integer(),

                        Forms\Components\TextInput::make('direccion'),

                        Forms\Components\TextInput::make('ci'),
                        Forms\Components\TextInput::make('nit'),
                        Forms\Components\TextInput::make('empresa'),
                        Forms\Components\Radio::make('estado')
                        ->options([
                            1 => 'Habilitado',
                            0 => 'Deshabilitado',
                        ])


                    ])
                 ]),
                Tables\Actions\DeleteAction::make(),
            ]);
            }
}
