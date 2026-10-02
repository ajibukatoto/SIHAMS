<?php

namespace App\Filament\Resources\TicketComments\Pages;

use App\Filament\Resources\TicketComments\TicketCommentResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTicketComment extends CreateRecord
{
    protected static string $resource = TicketCommentResource::class;

    protected function mutateFormDataBeforeCreate(
        array $data
    ): array {
        $data['user_id'] = Auth::id();

        if (! $this->canCreateInternalComment()) {
            $data['is_internal'] = false;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    private function canCreateInternalComment(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return DB::table('model_has_roles')
            ->join(
                'roles',
                'roles.id',
                '=',
                'model_has_roles.role_id'
            )
            ->where(
                'model_has_roles.model_id',
                $user->id
            )
            ->where(
                'model_has_roles.model_type',
                User::class
            )
            ->whereIn(
                'roles.name',
                [
                    'Super Admin',
                    'ICT Manager',
                    'ICT Technician',
                ]
            )
            ->exists();
    }
}
