<?php

namespace App\Filament\Resources\HelpDeskTickets\Pages;

use App\Filament\Resources\HelpDeskTickets\HelpDeskTicketResource;
use App\Models\HelpDeskTicket;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateHelpDeskTicket extends CreateRecord
{
    protected static string $resource = HelpDeskTicketResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /*
        |--------------------------------------------------------------------------
        | Automatically assign the logged-in user as requester
        |--------------------------------------------------------------------------
        */

        $data['requester_id'] = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | New tickets always start as Open
        |--------------------------------------------------------------------------
        */

        $data['status'] = 'open';

        /*
        |--------------------------------------------------------------------------
        | Record opening time
        |--------------------------------------------------------------------------
        */

        $data['opened_at'] = now();

        /*
        |--------------------------------------------------------------------------
        | Generate SIHAMS ticket number
        |--------------------------------------------------------------------------
        */

        $nextId = (HelpDeskTicket::max('id') ?? 0) + 1;

        $data['ticket_number'] = 'SIHAMS-' .
            now()->format('Ymd') . '-' .
            str_pad(
                (string) $nextId,
                5,
                '0',
                STR_PAD_LEFT
            );

        /*
        |--------------------------------------------------------------------------
        | New ticket should not already contain workflow timestamps
        |--------------------------------------------------------------------------
        */

        $data['assigned_at'] = null;
        $data['resolved_at'] = null;
        $data['closed_at'] = null;

        /*
        |--------------------------------------------------------------------------
        | Technician is not assigned during ticket creation
        |--------------------------------------------------------------------------
        */

        $data['assigned_to'] = null;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
