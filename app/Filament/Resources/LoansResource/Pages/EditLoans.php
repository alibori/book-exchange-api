<?php

namespace App\Filament\Resources\LoansResource\Pages;

use App\Filament\Resources\LoansResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLoans extends EditRecord
{
    protected static string $resource = LoansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
