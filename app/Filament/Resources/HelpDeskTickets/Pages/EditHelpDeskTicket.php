<?php

namespace App\Filament\Resources\HelpDeskTickets\Pages;

use App\Filament\Resources\HelpDeskTickets\HelpDeskTicketResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class EditHelpDeskTicket extends EditRecord
{
    protected static string $resource = HelpDeskTicketResource::class;

    protected function mutateFormDataBeforeSave(
        array $data
    ): array {
        $originalStatus = $this->record->status;
        $originalAssignedTo = $this->record->assigned_to;

        /*
         * Requester cannot be changed after ticket creation.
         */
        $data['requester_id'] = $this->record->requester_id;

        /*
         * Employee cannot change workflow fields.
         */
        if ($this->isEmployee()) {
            $data['assigned_to'] = $this->record->assigned_to;
            $data['status'] = $this->record->status;
            $data['resolution'] = $this->record->resolution;
        }

        /*
         * Only ICT Manager / Super Admin can assign technicians.
         */
        if (! $this->isManager()) {
            $data['assigned_to'] = $this->record->assigned_to;
        }

        /*
         * Automatically record assignment time.
         */
        if (
            empty($originalAssignedTo)
            && ! empty($data['assigned_to'])
        ) {
            $data['assigned_at'] = now();
        }

        if (
            ! empty($originalAssignedTo)
            && empty($data['assigned_to'])
        ) {
            $data['assigned_at'] = null;
        }

        /*
         * Automatically record resolution time.
         */
        if (
            $originalStatus !== 'resolved'
            && ($data['status'] ?? null) === 'resolved'
        ) {
            $data['resolved_at'] = now();
        }

        /*
         * Automatically record closing time.
         */
        if (
            $originalStatus !== 'closed'
            && ($data['status'] ?? null) === 'closed'
        ) {
            $data['closed_at'] = now();
        }

        /*
         * If ticket is reopened, clear future workflow timestamps.
         */
        if (
            in_array(
                $data['status'] ?? null,
                ['open', 'assigned', 'in_progress', 'pending'],
                true
            )
        ) {
            $data['closed_at'] = null;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    private function isManager(): bool
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
                ]
            )
            ->exists();
    }

    private function isEmployee(): bool
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
            ->where(
                'roles.name',
                'Employee'
            )
            ->exists();
    }
}
