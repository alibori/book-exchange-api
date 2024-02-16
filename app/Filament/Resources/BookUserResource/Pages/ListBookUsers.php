<?php

namespace App\Filament\Resources\BookUserResource\Pages;

use App\Filament\Resources\BookUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookUsers extends ListRecords
{
    protected static string $resource = BookUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
