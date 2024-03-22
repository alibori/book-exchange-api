<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum LoanStatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case Requested = 'requested';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Returned = 'returned';
    case Overdue = 'overdue';
    case Lost = 'lost';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Requested => __('Requested'),
            self::Approved => __('Approved'),
            self::Rejected => __('Rejected'),
            self::Returned => __('Returned'),
            self::Overdue => __('Overdue'),
            self::Lost => __('Lost'),
            self::Cancelled => __('Cancelled'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Requested, self::Overdue => 'warning',
            self::Approved, self::Returned => 'success',
            self::Rejected, self::Lost => 'danger',
            self::Cancelled => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Requested => 'heroicon-m-clock',
            self::Approved => 'heroicon-m-check',
            self::Rejected => 'heroicon-m-x-circle',
            self::Returned => 'heroicon-m-rewind',
            self::Overdue => 'heroicon-m-exclamation-circle',
            self::Lost => 'heroicon-m-exclamation-triangle',
            self::Cancelled => 'heroicon-m-x-circle',
        };
    }
}
