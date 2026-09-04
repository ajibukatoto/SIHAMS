<?php

namespace App\Filament\Resources\HelpDeskTickets\Pages;

use App\Filament\Resources\HelpDeskTickets\HelpDeskTicketResource;
use Filament\Resources\Pages\ListRecords;

class ListHelpDeskTickets extends ListRecords
{
    protected static string $resource = HelpDeskTicketResource::class;
}
