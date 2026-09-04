<?php

namespace App\Filament\Resources\HelpDeskTickets\Schemas;

use App\Models\Department;
use App\Models\Office;
use App\Models\User;
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
                    ->schema([
                        TextInput::make('ticket_number')
                            ->label('Ticket Number')
                            ->disabled()
                            ->dehydrated(false),

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
                            ->rows(5)
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
                            ->required(),

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
                    ->schema([
                        Select::make('assigned_to')
                            ->label('Assigned Technician')
                            ->relationship('technician', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'open' => 'Open',
                                'assigned' => 'Assigned',
                                'in_progress' => 'In Progress',
                                'pending' => 'Pending',
                                'resolved' => 'Resolved',
                                'closed' => 'Closed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('open')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Resolution')
                    ->schema([
                        Textarea::make('resolution')
                            ->label('Resolution / Work Done')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
