<?php

namespace App\Livewire;

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

class ListRol extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function render()
    {
        return view('livewire.list-rol');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Role::query())
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre'),
                    // ->searchable(), // Habilita la búsqueda en esta columna
                Tables\Columns\TextColumn::make('guard_name')
                    ->label('Guardia'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado el'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Crear Rol')  // Asegúrate de definir un label para que se muestre el texto
                    ->url(route('rol.create')) // Redirige a la ruta VMarca.index
                    ->openUrlInNewTab(false)
                    // ->visible(fn() => Auth::user()->can('rol.create')),
               ]);


    }
}
