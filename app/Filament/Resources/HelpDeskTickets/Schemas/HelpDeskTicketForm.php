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

                /*
                |--------------------------------------------------------------------------
                | Ticket Information
                |--------------------------------------------------------------------------
                */

                Section::make('Ticket Information')
                    ->description('Provide details about the ICT problem or service request.')
                    ->schema([

                        TextInput::make('ticket_number')
                            ->label('Ticket Number')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Generated automatically'),

                        TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Computer cannot connect to the network'),

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
                            ->columnSpanFull()
                            ->placeholder(
                                'Describe the problem, error message, affected equipment, or service required.'
                            ),
                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | Requester Information
                |--------------------------------------------------------------------------
                */

                Section::make('Requester Information')
                    ->description('Information about the employee reporting the issue.')
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
                            ->relationship('office', 'office_name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(3),

                /*
                |--------------------------------------------------------------------------
                | Assignment
                |--------------------------------------------------------------------------
                */

                Section::make('Assignment')
                    ->description('Ticket assignment and current workflow status.')
                    ->schema([

                        Select::make('assigned_to')
                            ->label('Assigned Technician')
                            ->relationship('technician', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Not assigned'),

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

                /*
                |--------------------------------------------------------------------------
                | Resolution
                |--------------------------------------------------------------------------
                */

                Section::make('Resolution')
                    ->description('Record the work performed and final resolution.')
                    ->schema([

                        Textarea::make('resolution')
                            ->label('Resolution / Work Done')
                            ->rows(6)
                            ->columnSpanFull()
                            ->placeholder(
                                'Describe the troubleshooting steps, action taken, and final resolution.'
                            ),
                    ]),
            ]);
    }
}
