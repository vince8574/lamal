<?php

namespace App\Filament\Resources\AgeRangeResource\Pages;

use App\Filament\Resources\AgeRangeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAgeRange extends EditRecord
{
    protected static string $resource = AgeRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
