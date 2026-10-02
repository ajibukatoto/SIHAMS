<?php

namespace App\Filament\Resources\HelpDeskTickets\Pages;

use App\Filament\Resources\HelpDeskTickets\HelpDeskTicketResource;
use App\Models\HelpDeskTicket;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateHelpDeskTicket extends CreateRecord
{
    protected static string $resource = HelpDeskTicketResource::class;

    protected function mutateFormDataBeforeCreate(
        array $data
    ): array {
        $data['requester_id'] = Auth::id();

        $data['status'] = 'open';

        $data['opened_at'] = now();

        $nextId = (HelpDeskTicket::max('id') ?? 0) + 1;

        $data['ticket_number'] =
            'SIHAMS-' .
            now()->format('Ymd') .
            '-' .
            str_pad(
                (string) $nextId,
                5,
                '0',
                STR_PAD_LEFT
            );

        $data['assigned_at'] = null;
        $data['resolved_at'] = null;
        $data['closed_at'] = null;
        $data['assigned_to'] = null;
        $data['resolution'] = null;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
