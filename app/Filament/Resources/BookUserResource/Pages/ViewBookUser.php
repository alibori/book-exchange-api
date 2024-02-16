<?php

namespace App\Filament\Resources\BookUserResource\Pages;

use App\Filament\Resources\BookUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBookUser extends ViewRecord
{
    protected static string $resource = BookUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
