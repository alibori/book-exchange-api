<?php

namespace App\Filament\Resources\BookUserResource\Pages;

use App\Filament\Resources\BookUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookUser extends CreateRecord
{
    protected static string $resource = BookUserResource::class;
}
