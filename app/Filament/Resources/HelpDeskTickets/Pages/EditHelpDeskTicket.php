<?php

namespace App\Filament\Resources\HelpDeskTickets\Pages;

use App\Filament\Resources\HelpDeskTickets\HelpDeskTicketResource;
use Filament\Resources\Pages\EditRecord;

class EditHelpDeskTicket extends EditRecord
{
    protected static string $resource = HelpDeskTicketResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
