<?php

namespace App\Filament\Resources\Departments\Schemas;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Department Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->label('Department Code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Description')
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true),

            ]);
    }
}
