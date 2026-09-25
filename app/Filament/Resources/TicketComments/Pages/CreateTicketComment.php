<?php

namespace App\Filament\Resources\TicketComments\Pages;

use App\Filament\Resources\TicketComments\TicketCommentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTicketComment extends CreateRecord
{
    protected static string $resource = TicketCommentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        if (
            ! (
                Auth::user()?->hasAnyRole([
                    'Super Admin',
                    'ICT Manager',
                    'ICT Technician',
                ]) ?? false
            )
        ) {
            $data['is_internal'] = false;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
