<?php

namespace App\Filament\Resources\HelpDeskTickets\Pages;

use App\Filament\Resources\HelpDeskTickets\HelpDeskTicketResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHelpDeskTicket extends CreateRecord
{
    protected static string $resource = HelpDeskTicketResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['ticket_number'] =
            'SIHAMS-' . now()->format('Y') . '-' .
            str_pad(
                (string) ((\App\Models\HelpDeskTicket::max('id') ?? 0) + 1),
                5,
                '0',
                STR_PAD_LEFT
            );

        $data['opened_at'] = now();

        return $data;
    }
}
