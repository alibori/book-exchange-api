<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BookUserStatusEnum: string implements HasLabel
{
    case Available = 'available';
    case Borrowed = 'borrowed';

    public function getLabel(): string
    {
        return match ($this) {
            self::Available => __(key: 'Available'),
            self::Borrowed => __(key: 'Borrowed'),
        };
    }
}
