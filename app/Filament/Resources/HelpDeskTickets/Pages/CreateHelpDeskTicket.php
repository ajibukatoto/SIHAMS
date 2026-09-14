<?php

namespace App\Filament\Resources\HelpDeskTickets\Pages;

use App\Filament\Resources\HelpDeskTickets\HelpDeskTicketResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateHelpDeskTicket extends CreateRecord
{
    protected static string $resource = HelpDeskTicketResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Automatically set the logged-in user as the requester.
        $data['requester_id'] = Auth::id();

        // Every newly created ticket starts as Open.
        $data['status'] = 'open';

        // Record when the ticket was opened.
        $data['opened_at'] = now();

        // Generate a unique SIHAMS ticket number.
        $data['ticket_number'] =
            'SIHAMS-' .
            now()->format('Ymd-His') .
            '-' .
            strtoupper(substr(uniqid(), -5));

        // These fields must be empty when a ticket is first created.
        $data['assigned_to'] = null;
        $data['assigned_at'] = null;
        $data['resolved_at'] = null;
        $data['closed_at'] = null;
        $data['resolution'] = null;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
