<?php

namespace App\Filament\Resources\HelpDeskTickets;

use App\Filament\Resources\HelpDeskTickets\Pages\CreateHelpDeskTicket;
use App\Filament\Resources\HelpDeskTickets\Pages\EditHelpDeskTicket;
use App\Filament\Resources\HelpDeskTickets\Pages\ListHelpDeskTickets;
use App\Filament\Resources\HelpDeskTickets\Schemas\HelpDeskTicketForm;
use App\Filament\Resources\HelpDeskTickets\Tables\HelpDeskTicketsTable;
use App\Models\HelpDeskTicket;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class HelpDeskTicketResource extends Resource
{
    protected static ?string $model = HelpDeskTicket::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationLabel = 'Help Desk Tickets';

    protected static ?string $modelLabel = 'Help Desk Ticket';

    protected static ?string $pluralModelLabel = 'Help Desk Tickets';

    public static function form(Schema $schema): Schema
    {
        return HelpDeskTicketForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HelpDeskTicketsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHelpDeskTickets::route('/'),
            'create' => CreateHelpDeskTicket::route('/create'),
            'edit' => EditHelpDeskTicket::route('/{record}/edit'),
        ];
    }
}
