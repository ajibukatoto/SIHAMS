<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected string $selectedRole;

    protected function mutateFormDataBeforeSave(
        array $data
    ): array {
        $this->selectedRole = $data['role'];

        unset($data['role']);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->syncRoles([
            $this->selectedRole,
        ]);
    }

    protected function mutateFormDataBeforeFill(
        array $data
    ): array {
        $data['role'] = $this->record
            ->roles()
            ->pluck('name')
            ->first();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
