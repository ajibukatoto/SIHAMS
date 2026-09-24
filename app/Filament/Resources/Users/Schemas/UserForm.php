<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Account Information')
                    ->description(
                        'Create and manage system user accounts and their assigned role.'
                    )
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

                        Select::make('role')
                            ->label('Role')
                            ->options(
                                Role::query()
                                    ->where('guard_name', 'web')
                                    ->orderBy('name')
                                    ->pluck('name', 'name')
                                    ->toArray()
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText(
                                'Assign one primary role to this user.'
                            ),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->minLength(8)
                            ->maxLength(255)
                            ->required(
                                fn (string $operation): bool =>
                                    $operation === 'create'
                            )
                            ->dehydrated(
                                fn (?string $state): bool =>
                                    filled($state)
                            )
                            ->autocomplete('new-password'),
                    ])
                    ->columns(2),
            ]);
    }
}
