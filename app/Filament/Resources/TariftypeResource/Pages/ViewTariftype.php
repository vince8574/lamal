<?php

namespace App\Filament\Resources\TariftypeResource\Pages;

use App\Filament\Resources\TariftypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTariftype extends ViewRecord
{
    protected static string $resource = TariftypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
