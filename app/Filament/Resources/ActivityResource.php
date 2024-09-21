<?php

namespace App\Filament\Resources;

use Z3d0X\FilamentLogger\Resources\ActivityResource as BaseResource;

class ActivityResource extends BaseResource
{
    /**
     * The resource navigation sort order.
     */
    protected static ?int $navigationSort = 1;

    /**
     * Get the navigation badge for the resource.
     */
    public static function getPluralLabel(): string
    {
        return __('manageactivity'); // جمع
    }
    public static function getNavigationBadge(): ?string
    {
        return number_format(static::getModel()::count());
    }
    public static function getNavigationGroup(): ?string
    {
        return __(key: 'settings');
    }
}
