<?php

namespace App\Filament\Resources\BookApplicationResource\Pages;

use App\Filament\Resources\BookApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookApplication extends EditRecord
{
    protected static string $resource = BookApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
