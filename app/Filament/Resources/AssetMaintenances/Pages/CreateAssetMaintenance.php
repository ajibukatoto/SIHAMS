<?php

namespace App\Filament\Resources\AssetMaintenances\Pages;

use App\Filament\Resources\AssetMaintenances\AssetMaintenanceResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

class CreateAssetMaintenance extends CreateRecord
{
    protected static string $resource = AssetMaintenanceResource::class;
    #[Override]
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
