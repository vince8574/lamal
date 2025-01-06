<?php

namespace App\Filament\Resources\TariftypeResource\Pages;

use App\Filament\Resources\TariftypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTariftype extends EditRecord
{
    protected static string $resource = TariftypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
