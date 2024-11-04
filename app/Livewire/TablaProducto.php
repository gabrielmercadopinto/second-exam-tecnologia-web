<?php

namespace App\Livewire;


use App\Models\Producto;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TablaProducto extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function render()
    {
        return view('livewire.tabla-producto');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Producto::query())
            ->columns([
                Tables\Columns\TextColumn::make('codigo_oem')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(), // Habilita la búsqueda en esta columna
                Tables\Columns\TextColumn::make('precio'),
                Tables\Columns\TextColumn::make('stock'),
                Tables\Columns\TextColumn::make('stock_minimo'),
                Tables\Columns\IconColumn::make('estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('categoria.nombre'),
                Tables\Columns\TextColumn::make('marca.nombre'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable',
                    ])
            ])
            ->actions([
                // Acción para Editar
                Tables\Actions\EditAction::make()
                    ->modalHeading('Editar Producto')
                    ->label('Editar')
                    //aplicar roles y permiso, no mostrar para empleados
                    ->visible(fn() => Auth::user()->can('producto.edit'))
                    ->form([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('codigo_oem')
                                    ->label('Código OEM')
                                    ->required()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('codigo_oem', strtoupper($state))), // Convierte a mayúsculas
                                Forms\Components\TextInput::make('nombre')
                                    ->columnSpan(2)
                                    ->required(),
                                Forms\Components\TextInput::make('precio')->required()->numeric(),
                                Forms\Components\TextInput::make('unidad'),
                                // Forms\Components\TextInput::make('stock')
                                //     ->label('Stock')
                                //     ->required()
                                //     ->numeric()
                                //     ->integer(),
                                Forms\Components\TextInput::make('stock_minimo')
                                    ->label('Stock Mínimo')
                                    ->required()
                                    ->numeric()
                                    ->integer(),
                                Forms\Components\Select::make('categoria_id')
                                    ->relationship('categoria', 'nombre')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\TextInput::make('ubicacion')
                                    ->required(),
                                Forms\Components\Select::make('marca_id')
                                    ->relationship('marca', 'nombre')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Radio::make('estado')
                                    ->columnSpan(2)
                                    ->options([
                                        1 => 'Habilitado',
                                        0 => 'Deshabilitado',
                                    ])
                            ])
                    ]),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                // Botón de redirección a la lista de marcas
                Tables\Actions\Action::make('marcas')
                    ->label('Ir a Marcas y Categorías') // Asegúrate de definir un label para que se muestre el texto
                    ->url(route('producto.marca')) // Redirige a la ruta VMarca.index
                    ->openUrlInNewTab(false), // Define si la URL se abre en la misma pestaña o una nueva

                Tables\Actions\CreateAction::make()
                    ->label('Crear Producto')  // Asegúrate de definir un label para que se muestre el texto
                    ->modalHeading('Nuevo Producto')
                    ->slideOver()
                    ->visible(fn() => Auth::user()->can('producto.create'))
                    ->model(Producto::class)
                    ->form([
                        //grid de 3 columans
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('codigo_oem')
                                    ->required(),
                                //ejeuctar metodo, conveira a mayuscula


                                Forms\Components\TextInput::make('nombre')
                                    ->required()
                                    ->columnSpan(2), // Ocupa 2 columnas
                                Forms\Components\TextInput::make('precio')->required()->numeric(),
                                Forms\Components\TextInput::make('unidad')
                                    ->default('unidad'),

                                // Aquí agregamos el selector de categorías
                                Forms\Components\Select::make('categoria_id')
                                    ->relationship('categoria', 'nombre') // Usa la relación definida en el modelo Product
                                    ->searchable()
                                    ->preload()
                                    ->live() // Actualiza la lista de categorías en tiempo real
                                    ->required() // Hacemos que el campo sea obligatorio
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('nombre')
                                            ->label('Nombre de la nueva Categoría')
                                            ->required(),
                                        Forms\Components\TextInput::make('descripcion')
                                            ->label('Nombre de la nueva Descricion')
                                            ->required(),
                                    ]), // Abre el formulario para crear una nueva categoría


                                // Forms\Components\TextInput::make('stock')
                                // ->label('Stock')
                                // ->required()
                                // ->numeric() // Permite solo números
                                // ->integer() // Valida como número entero
                                // ->placeholder('Ingrese el stock'),

                                Forms\Components\TextInput::make('stock_minimo')
                                    ->label('Stock Minimo')
                                    ->required()
                                    ->numeric() // Permite solo números
                                    ->integer() // Valida como número entero
                                    ->placeholder('Ingrese el stock minimo'),
                                    Forms\Components\TextInput::make('ubicacion')
                                    ->placeholder('Ejemplo: A1'),


                                Forms\Components\Select::make('marca_id')
                                    ->relationship('marca', 'nombre') // Usa la relación definida en el modelo Product
                                    ->required() // Hacemos que el campo sea obligatorio
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('nombre')
                                            ->label('Nombre de la nueva marca')
                                            ->required(),
                                    ]) // Abre el formulario para crear una nueva marca



                            ]),
                        Forms\Components\Radio::make('estado')
                            ->inline()
                            ->default(1)
                            ->options([
                                1 => 'Habilitado',
                                0 => 'Deshabilitado',
                            ])
                    ])

            ]);
    }
}
