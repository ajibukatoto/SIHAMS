<?php

namespace App\Filament\Resources\HelpDeskTickets\Pages;

use App\Filament\Resources\HelpDeskTickets\HelpDeskTicketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHelpDeskTickets extends ListRecords
{
    protected static string $resource = HelpDeskTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create Ticket')
                ->icon('heroicon-o-plus'),
        ];
    }
}
