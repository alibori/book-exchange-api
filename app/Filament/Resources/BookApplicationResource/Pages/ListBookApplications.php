<?php

namespace App\Filament\Resources\BookApplicationResource\Pages;

use App\Filament\Resources\BookApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookApplications extends ListRecords
{
    protected static string $resource = BookApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
