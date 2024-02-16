<?php

namespace App\Filament\Widgets;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '180s';

    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Users'), User::all()->count()),
            Stat::make(__('Total Books'), Book::all()->count()),
            Stat::make(__('Total Authors'), Author::all()->count()),
        ];
    }
}
