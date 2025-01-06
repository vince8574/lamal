<?php

namespace App\Filament\Resources\TariftypeResource\Pages;

use App\Filament\Resources\TariftypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTariftypes extends ListRecords
{
    protected static string $resource = TariftypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
