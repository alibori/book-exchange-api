<?php

namespace App\Filament\Resources\BookUserResource\Pages;

use App\Filament\Resources\BookUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookUser extends EditRecord
{
    protected static string $resource = BookUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
