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
        // Automatically set the logged-in user as the comment author.
        $data['user_id'] = Auth::id();

        return $data;
    }
}
