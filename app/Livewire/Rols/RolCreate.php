<?php

namespace App\Livewire\Rols;


use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Livewire\Component;

class RolCreate extends Component implements Forms\Contracts\HasForms
{

    use Forms\Concerns\InteractsWithForms;

    public function render()
    {

        return view('livewire.rols.rol-create');
    }



    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos Rol')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->minLength(3)
                            ->maxLength(100)
                            ->required()
                    ]),
                Forms\Components\Section::make('Elegir Permisos')
                    ->schema([
                        Forms\Components\Grid::make(5) // Grid de 3 columnas
                        ->schema([
                            Forms\Components\CheckboxList::make('permissions')
                                ->label('Botones NavBar')
                                ->options(
                                    Permission::where('name', 'like', 'navbar.%')->pluck('name', 'id')
                                    )
                                ->bulkToggleable(), // Permite seleccionar/desmarcar todas las opciones


                                Forms\Components\CheckboxList::make('permissions')
                                    ->label('Vista Productos')
                                    ->options(
                                        Permission::where('name', 'like', 'producto.%')->pluck('name', 'id')
                                        )
                                    ->bulkToggleable(), // Permite seleccionar/desmarcar todas las opciones

                                    Forms\Components\CheckboxList::make('permissions')
                                    ->label('Vista Productos')
                                    ->options(
                                        Permission::where('name', 'like', 'producto.%')->pluck('name', 'id')
                                        )
                                    ->bulkToggleable(), // Permite seleccionar/desmarcar todas las opciones

                                Forms\Components\CheckboxList::make('permissions')
                                    ->label('Vista Productos')
                                    ->options(
                                        Permission::where('name', 'like', 'producto.%')->pluck('name', 'id')
                                        )
                                    ->bulkToggleable(), // Permite seleccionar/desmarcar todas las opciones

                                Forms\Components\CheckboxList::make('permissions')
                                    ->label('Vista Clientes')
                                    ->options(
                                        Permission::where('name', 'like', 'cliente.%')->pluck('name', 'id')
                                        )
                                    ->bulkToggleable(), // Permite seleccionar/desmarcar todas las opciones

                                Forms\Components\CheckboxList::make('permissions')
                                    ->label('Vista Productos')
                                    ->options(
                                        Permission::where('name', 'like', 'producto.%')->pluck('name', 'id')
                                        )
                                    ->bulkToggleable(),



                                ]),
                    ]),
                    // Botón de guardar
                    Forms\Components\Actions::make([
                        Forms\Components\Actions\Action::make('guardar')
                            ->label('Guardar')
                            ->color('primary')
                            ->action(fn() => $this->guardar()), // Define la función de acción
                    ]),

            ]);
    }
}
