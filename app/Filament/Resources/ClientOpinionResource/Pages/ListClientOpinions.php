<?php

namespace App\Filament\Resources\ClientOpinionResource\Pages;

use App\Filament\Resources\ClientOpinionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientOpinions extends ListRecords
{
    protected static string $resource = ClientOpinionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
