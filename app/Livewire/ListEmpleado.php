<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ListEmpleado extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;
    public function render()
    {
        return view('livewire.list-empleado');
    }



    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->placeholder('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->placeholder('Nombre')
                    ->searchable(), // Habilita la búsqueda en esta columna
                Tables\Columns\TextColumn::make('email')
                    ->placeholder('Correo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name'),

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
                    ->label('Registrar Empleado')  // Asegúrate de definir un label para que se muestre el texto
                    ->modalHeading('Registrar Empleado')
                    ->slideOver()
                    // ->visible(fn() => Auth::user()->can('producto.create'))
                    ->model(User::class)
                    ->form([
                        //grid de 3 columans
                        Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre')
                                ->required()
                                ->columnSpan(2),
                                //ejeuctar metodo, conveira a mayuscula


                                // Ocupa 2 columnas
                            Forms\Components\TextInput::make('email')
                                ->label('Correo')
                                ->required()
                                ->email(),
                            Forms\Components\Select::make('role')
                                    ->options(Role::all()->pluck('name', 'id'))
                                    ->relationship('roles', 'name') // Relacionar con roles
                                 ->searchable()
                                ->preload()
                                ->live() // Actualiza la lista de categorías en tiempo real
                                ->required(), // Hacemos que el campo sea obligatorio
                                // Abre el formulario para crear una nueva categoría
                                // Forms\Components\TextInput::make('password')
                                // ->label('Contraseña')
                                // ->required()
                                // ->password()
                                // //ver contraseña
                                // ->columnSpan(2)
                                // ->placeholder('Ingrese la contraseña'),

                         ]),
                        ])

            ])
            ->actions([
                 // Acción para Editar
                 Tables\Actions\EditAction::make()
                 ->modalHeading('Editar Empleado')
                 ->label('Editar')
                 //aplicar roles y permiso, no mostrar para empleados
                // ->visible(fn() => Auth::user()->can('producto.edit'))
                 ->form([
                    Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                        ->label('Nombre')
                        ->required()
                        ->columnSpan(2),
                        //ejeuctar metodo, conveira a mayuscula


                        // Ocupa 2 columnas
                    Forms\Components\TextInput::make('email')
                        ->label('Correo')
                        ->required()
                        ->email(),
                    Forms\Components\Select::make('role')
                            ->options(Role::all()->pluck('name', 'id'))
                            ->relationship('roles', 'name') // Relacionar con roles
                         ->searchable()
                        ->preload()
                        ->live() // Actualiza la lista de categorías en tiempo real
                        ->required(), // Hacemos que el campo sea obligatorio
                        // Abre el formulario para crear una nueva categoría
                        // Forms\Components\TextInput::make('password')
                        // ->label('Contraseña')
                        // ->password()
                        // //ver contraseña
                        // ->columnSpan(2)
                        // ->placeholder('Ingrese la contraseña'),


                    ])
                 ]),
                Tables\Actions\DeleteAction::make(),
            ]);
            }
}
