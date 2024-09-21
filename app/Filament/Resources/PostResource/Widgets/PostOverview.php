<?php

namespace App\Filament\Resources\PostResource\Widgets;

use Modules\Mag\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class PostOverview extends BaseWidget
{
    /**
     * The widget stats.
     */
    protected function getStats(): array
    {
        $posts = Post::count();
        $published = Post::published()->count();
        $drafts = Post::drafts()->count();

        return [
            Stat::make(__('total'), Number::format($posts))
                ->description(__('total_posts_description'))
                ->icon('heroicon-o-book-open'),

            Stat::make(__('published'), Number::format($published))
                ->description(__('published_posts_description'))
                ->icon('heroicon-o-check-circle'),

            Stat::make(__('draft'), Number::format($drafts))
                ->description(__('draft_posts_description'))
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
