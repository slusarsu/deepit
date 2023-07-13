<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class PostStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $pages = Post::query()->get();
        return [
            Card::make('Posts', $pages->count()),
            Card::make('Enabled', $pages->where('is_enabled', true)->count()),
            Card::make('Disabled', $pages->where('is_enabled', false)->count()),
            Card::make('Removed', Post::onlyTrashed()->count()),
        ];
    }
}
