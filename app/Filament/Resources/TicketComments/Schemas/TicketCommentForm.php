<?php

namespace App\Filament\Resources\TicketComments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TicketCommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ticket Comment')
                    ->description('Add a comment to a help desk ticket.')
                    ->schema([

                        Select::make('help_desk_ticket_id')
                            ->label('Help Desk Ticket')
                            ->relationship('ticket', 'ticket_number')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('user_id')
                            ->label('Commented By')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Textarea::make('comment')
                            ->label('Comment')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),

                        Toggle::make('is_internal')
                            ->label('Internal Comment')
                            ->helperText(
                                'Enable this if the comment should be visible only to authorized ICT staff.'
                            )
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }
}
