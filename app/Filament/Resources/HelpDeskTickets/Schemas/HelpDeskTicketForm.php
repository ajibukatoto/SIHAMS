<?php

namespace App\Filament\Resources\HelpDeskTickets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HelpDeskTicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ticket Information')
                    ->description('Enter the details of the ICT problem or service request.')
                    ->schema([
                        TextInput::make('ticket_number')
                            ->label('Ticket Number')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Generated automatically'),

                        TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->maxLength(255),

                        Select::make('category')
                            ->label('Category')
                            ->options([
                                'hardware' => 'Hardware',
                                'software' => 'Software',
                                'network' => 'Network',
                                'printer' => 'Printer',
                                'email' => 'Email',
                                'system' => 'System',
                                'user_account' => 'User Account',
                                'other' => 'Other',
                            ])
                            ->required()
                            ->searchable(),

                        Select::make('priority')
                            ->label('Priority')
                            ->options([
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                                'critical' => 'Critical',
                            ])
                            ->default('medium')
                            ->required(),

                        Textarea::make('description')
                            ->label('Problem Description')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Requester Information')
                    ->schema([
                        Select::make('requester_id')
                            ->label('Requester')
                            ->relationship('requester', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled()
                            ->dehydrated(),

                        Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('office_id')
                            ->label('Office')
                            ->relationship('office', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(3),

                Section::make('Assignment')
                    ->description('Assignment and ticket status are controlled by the Help Desk workflow.')
                    ->schema([
                        TextInput::make('assigned_to_display')
                            ->label('Assigned Technician')
                            ->formatStateUsing(function ($record) {
                                return $record?->technician?->name ?? 'Unassigned';
                            })
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('status_display')
                            ->label('Current Status')
                            ->formatStateUsing(function ($record) {
                                return $record
                                    ? str($record->status)
                                        ->replace('_', ' ')
                                        ->title()
                                    : 'Open';
                            })
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->visibleOn('edit'),

                Section::make('Resolution')
                    ->schema([
                        Textarea::make('resolution')
                            ->label('Resolution / Work Done')
                            ->rows(5)
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->visibleOn('edit'),
            ]);
    }
}
