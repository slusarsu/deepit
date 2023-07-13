<?php

namespace App\Filament\Resources\PageResource\Widgets;

use App\Models\Page;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class PageStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $pages = Page::query()->get();
        return [
            Card::make('Pages', $pages->count()),
            Card::make('Enabled', $pages->where('is_enabled', true)->count()),
            Card::make('Disabled', $pages->where('is_enabled', false)->count()),
            Card::make('Removed', Page::onlyTrashed()->count()),
        ];
    }
}
