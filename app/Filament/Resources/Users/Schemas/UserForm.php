<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Account Information')
                    ->description('Create and manage system user accounts and their assigned roles.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Select::make('roles')
                            ->label('Role')
                            ->relationship('roles', 'name')
                            ->searchable()
                            ->preload()
                            ->multiple()
                            ->required()
                            ->helperText('Select the role or roles assigned to this user.'),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->minLength(8)
                            ->maxLength(255)
                            ->required(
                                fn (string $operation): bool => $operation === 'create'
                            )
                            ->dehydrated(
                                fn (?string $state): bool => filled($state)
                            )
                            ->autocomplete('new-password'),
                    ])
                    ->columns(2),
            ]);
    }
}
