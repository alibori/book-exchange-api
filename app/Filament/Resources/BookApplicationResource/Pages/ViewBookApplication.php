<?php

namespace App\Filament\Resources\BookApplicationResource\Pages;

use App\Filament\Resources\BookApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBookApplication extends ViewRecord
{
    protected static string $resource = BookApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
