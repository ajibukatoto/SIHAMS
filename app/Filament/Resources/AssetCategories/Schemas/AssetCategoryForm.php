<?php

namespace App\Filament\Resources\AssetCategories\Schemas;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AssetCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Category Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->label('Category Code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true),

            ]);
}
}
