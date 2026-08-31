<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Asset Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('code')
                    ->label('Asset Code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),

                Select::make('asset_category_id')
                    ->relationship('assetCategory', 'name')
                    ->label('Asset Category')
                    ->searchable()
                    ->preload()
                    ->required(),

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
